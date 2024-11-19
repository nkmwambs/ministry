<?php 

use Hashids\Hashids;

if(!function_exists('hash_id')){
    function hash_id($id, $dir = "encode"): string|int {
        $hashids = new Hashids("Church-Manager");

        if($dir == 'encode'){
            return $hashids->encode($id);
        }else{
           return $hashids->decode($id)[0];
        }
    }
}

if(!function_exists('report_template')){
    function report_template(array $report_metadata, array $report_fields, $report_period): string {
        return view('templates/report_template', compact('report_metadata', 'report_fields'));
    }
}

if(!function_exists('formatUserDataForExport')){
    function formatUserDataForExport($user_data) {
    
        if (isset($user_data['first_name'])) {
            $user_data['first_name'] = ucfirst(strtolower($user_data['first_name']));
        }
    
        if (isset($user_data['last_name'])) {
            $user_data['last_name'] = ucfirst(strtolower($user_data['last_name']));
        }
    
        return $user_data;
    }
}


if(!function_exists('button_row')){
    function button_row($feature, $parent_id = null){
        if(auth()->user()->canDo("$feature.create")){
            return view("templates/button_row", compact('feature', 'parent_id'));
        }
    }
}

if(!function_exists('datatable')){
    function datatable($table_id, $columns){
        return view('templates/datatable',['table_id' => $table_id, 'columns' => $columns]);
    }
}

if(!function_exists('sanitizeColumns')){
    function sanitizeColumns($table, $columns){
        // log_message('error', json_encode($columns));
        $sanitizedColumns['headerColumns'] = $columns;
        $sanitizedColumns['queryColumns'] = $columns;

        if($table == 'members'){
            for($i = 0; $i < count($columns); $i++){
                if($columns[$i] == "$table.id"){
                    $sanitizedColumns['headerColumns'][$i] = 'Action';
                }
    
                if(str_ends_with($columns[$i], '_id')){
                    $table = plural(substr($columns[$i], 0, -3));
                    $derived_column_alias = singular($table)."_name";
    
                    if(!in_array($derived_column_alias,$sanitizedColumns['headerColumns'])){
                        $sanitizedColumns['headerColumns'][$i] = $derived_column_alias;
                        $sanitizedColumns['queryColumns'][$i] = $table.".name";
                    }else{
                        unset($sanitizedColumns['headerColumns'][$i]);
                        unset($sanitizedColumns['queryColumns'][$i]);
                    }
                }
    
                $explodeColumnAlias = explode(' as ', $columns[$i]);
                if(count($explodeColumnAlias) > 1){
                    $column_name = $explodeColumnAlias[0];
                    $column_alias = $explodeColumnAlias[1];
        
                    if(!in_array($column_alias,$sanitizedColumns['headerColumns'])){
                        $sanitizedColumns['headerColumns'][$i] = $column_alias;
                        $sanitizedColumns['queryColumns'][$i] = $column_name;
                    }else{
                        unset($sanitizedColumns['queryColumns'][$i]);
                        unset($sanitizedColumns['headerColumns'][$i]);
                    }
                }

    
                if($columns[$i] != $table.".id"){
                    $otherTablesAliases = explode(".",$columns[$i]);
                    if(count($otherTablesAliases) > 1){
                        $sanitizedColumns['headerColumns'][$i] = singular($otherTablesAliases[0]).'_'.$otherTablesAliases[1];
                    }
                }
                
            }
           
        }


        $sanitizedColumns['headerColumns'] = array_values($sanitizedColumns['headerColumns']);
        $sanitizedColumns['queryColumns'] = array_values($sanitizedColumns['queryColumns']);

        //  log_message('error', json_encode($sanitizedColumns));

        return $sanitizedColumns;
    }
}

// if(!function_exists('normalizeForeignKeysNameField')){
//     function normalizeForeignKeysNameField($columns){
//         for($i = 0; $i < count($columns); $i++){
//             if(strpos($columns[$i], '_id') > 0){
//                 $table = substr($columns[$i], 0, -3);
//                 $columns[$i] = plural($table).".name";
//             }
//         }
//         log_message('error', json_encode($columns));
//         return $columns;
//     }
// }
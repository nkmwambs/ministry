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
        log_message('error', json_encode($feature));
        if(auth()->user()->canDo("$feature.create")){
            return view("templates/button_row", compact('feature', 'parent_id'));
        }
    }
}

// if(!function_exists('delete_permission')){
//     function delete_permission($tableName){
//         $str = singular($tableName).".read";
// 		$str .= singular($tableName).".create";
// 		$str .= singular($tableName).".update";
// 		$str .= singular($tableName).".delete";

//         return $str;
//     }
// }

// if(!function_exists('create_permission')){
//     function create_permission($tableName){
//         $str = singular($tableName).".read";
// 		$str .= ",".singular($tableName).".create";
//         return $str;
//     }
// }

// if(!function_exists('update_permission')){
//     function update_permission($tableName){
//         $str = singular($tableName).".read";
// 		$str .= singular($tableName).".create";
//         $str .= singular($tableName).".update";
//         return $str;
//     }
// }
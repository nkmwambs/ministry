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
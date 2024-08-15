<?php 

use Hashids\Hashids;

if(!function_exists('hash_id')){
    function hash_id($id, $dir = "encode") {
        $hashids = new Hashids("Church-Manager");

        if($dir == 'encode'){
            return $hashids->encode($id);
        }else{
            return $hashids->decode($id);
        }
    }
}
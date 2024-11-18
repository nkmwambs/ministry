<?php 
namespace App\Traits;
trait DatabaseTrait {
    function tableJoins(){
        $table = $this->table;
        $lookupTables = [];

        if(
            property_exists($this, 'lookupTables')
            && is_array($lookupTables = $this->lookupTables)
            && count($lookupTables) > 0
        ){
            foreach($lookupTables as $joinTable){
                $relationId = singular($joinTable).'_id';
                $idField = 'id';

                $this->join($joinTable, "$table.$relationId=$joinTable.$idField");
            }
        }
    }
}
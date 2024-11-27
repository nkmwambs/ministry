<?php 
namespace App\Traits;
trait DatabaseTrait {
    function tableJoins($queryCondition = []){
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

                if(!empty($queryCondition)){
                    if(array_key_exists($joinTable, $queryCondition)){
                        if(is_array($queryCondition[$joinTable])){
                            $this->whereIn("$joinTable.id", $queryCondition[$joinTable]);
                        }else{
                            $this->where("$joinTable.id", $queryCondition[$joinTable]);
                        }
                        
                    }
                }
            }
        }
    }

 
}
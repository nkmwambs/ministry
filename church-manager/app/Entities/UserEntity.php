<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class UserEntity extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];

    function getFirstName(){
        return strtoupper($this->attributes['first_name']);
    }

    function getLastName(){
        return strtoupper($this->attributes['last_name']);
    }

    function setFirstName($first_name, $last_name){
        $this->attributes['first_name'] = ucwords($first_name);
    }

    function setLastName($first_name, $last_name){
        $this->attributes["last_name"] = ucwords($last_name);
    }
}

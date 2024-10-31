<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class UserEntity extends Entity
{
    protected $attributes = [
        "id"                   => NULL,
        "denomination_id"      => NULL,
        "first_name"           => NULL,
        "last_name"            => NULL,
        "username"             => NULL,
        "biography"            => NULL,
        "date_of_birth"        => NULL,
        "email"                => NULL,
        "gender"               => NULL,
        "phone"                => NULL,
        "roles"                => NULL,
        "access_count"         => NULL,
        "is_active"            => NULL,
        "permitted_entities"   => NULL,
        "permitted_assemblies" => NULL,
        "created_at"           => NULL,
        "updated_at"           => NULL,
        "password"             => NULL
    ];

    protected $datamap = [
        "first_name" => "first_name",
        "last_name"  => "last_name"
    ];
    protected $dates   = [
        'created_at', 'updated_at', 'deleted_at'
    ];
    protected $casts   = [
        "is_active" => 'boolean',
    ];

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

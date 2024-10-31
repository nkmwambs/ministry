<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Event extends Entity
{
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];
    

    function setCode($originalCode){
        $this->attributes['event_code'] = $this->sanitizeEventCode($originalCode); 

        return $this;
    }

    private function sanitizeEventCode($rawCode){
        $sanitizedCode = strtoupper(preg_replace('/[\s\W]+/', '', $rawCode));
        return $sanitizedCode;
    }

    function getRegistrationFees(){
        return number_format($this->attributes['registration_fees'],2);
    }

}

<?php 

namespace App\Interfaces;

Interface ModelInterface {
    function getAll();
    function getOne($id);
}
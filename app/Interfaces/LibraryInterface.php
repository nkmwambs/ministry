<?php 

namespace App\Interfaces;

Interface LibraryInterface {
    function unsetListQueryFields();
    function unsetViewQueryFields();
    function setListQueryFields();
    function setViewQueryFields();
}
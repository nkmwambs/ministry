<?php 

namespace App\Libraries;

class FeatureLibrary implements \App\Interfaces\LibraryInterface {
    function unsetListQueryFields(){

    }

    function unsetViewQueryFields(){

    }

    function setListQueryFields(){
        $fields = [];
        return $fields;
    }

    function setViewQueryFields(){
        $fields = [];
        return $fields;
    }

    function navigationItems(){

        $items = [
            "admin" => [
                'dashboards' => ['label' => 'dashboards', 'iconClass' => 'entypo-gauge', 'uri' => ''],
                'denominations' => ['label' => 'denominations', 'iconClass' => 'entypo-trophy', 'uri' => ''],
                'ministers' => ['label' => 'ministers', 'iconClass' => 'entypo-book', 'uri' => ''],
                'assemblies' => ['label' => 'assemblies', 'iconClass' => 'entypo-home', 'uri' => ''],
                'events' => ['label' => 'events', 'iconClass' => 'entypo-layout', 'uri' => ''],
                'reports' => [
                                'label' => 'reports', 'iconClass' => 'entypo-newspaper', 'uri' => '',
                                'children' => $this->getReportTypeMenus()
                            ],
                'users' => ['label' => 'users', 'iconClass' => 'entypo-users', 'uri' => ''],
                'settings' => ['label' => 'settings', 'iconClass' => 'entypo-cog', 'uri' => ''],
            ],
            "church" => [
                'dashboards' => ['label' => 'my_dashboard', 'iconClass' => 'entypo-gauge', 'uri' => ''],
                'assemblies' => ['label' => 'my_assembly', 'iconClass' => 'entypo-home', 'uri' => ''],
                'users' => ['label' => 'my_profile', 'iconClass' => 'entypo-users', 'uri' => ''],
            ]

        ];

        return $items;
    }


    function getReportTypeMenus(){
        // session()->get('user_denomination_id')
        $types = new \App\Models\TypesModel();
        $reportTypes = $types->select('name,id')->findAll();

        $menus = [];

        if(count($reportTypes) > 0){
            foreach($reportTypes as $reportType){
                $menus[hash_id($reportType['id'], 'encode')] = ['label' => $reportType['name'], 'iconClass' => '', 'uri' => 'list'];
            }
        }

        return $menus;
        
    }

}
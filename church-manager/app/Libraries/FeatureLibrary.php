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

        // [
        //     'monthly_report' => ['label' => 'Monthly Reports', 'iconClass' => ''],
        //     'quarterly_report' => ['label' => 'Quarterly Reports', 'iconClass' => '']
        // ]

        $items = [
            'dashboards' => ['label' => 'Dashboard', 'iconClass' => 'entypo-gauge', 'uri' => ''],
            'denominations' => ['label' => 'Denominations', 'iconClass' => 'entypo-trophy', 'uri' => ''],
            'ministers' => ['label' => 'Ministers', 'iconClass' => 'entypo-book', 'uri' => ''],
            'assemblies' => ['label' => 'Assemblies', 'iconClass' => 'entypo-home', 'uri' => ''],
            'events' => ['label' => 'Events', 'iconClass' => 'entypo-layout', 'uri' => ''],
            'reports' => [
                            'label' => 'Reports', 'iconClass' => 'entypo-newspaper', 'uri' => '',
                            'children' => $this->getReportTypeMenus()
                        ],
            'users' => ['label' => 'Users', 'iconClass' => 'entypo-users', 'uri' => ''],
            'settings' => ['label' => 'Settings', 'iconClass' => 'entypo-cog', 'uri' => ''],
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
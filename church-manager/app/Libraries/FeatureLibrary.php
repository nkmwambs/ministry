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
            'dashboards' => ['label' => 'Dashboard', 'iconClass' => 'entypo-gauge'],
            'denominations' => ['label' => 'Denominations', 'iconClass' => 'entypo-trophy'],
            'ministers' => ['label' => 'Ministers', 'iconClass' => 'entypo-book'],
            'assemblies' => ['label' => 'Assemblies', 'iconClass' => 'entypo-home'],
            'events' => ['label' => 'Events', 'iconClass' => 'entypo-layout'],
            'reports' => [
                            'label' => 'Reports', 'iconClass' => 'entypo-newspaper',
                            'children' => [
                                    'monthly_report' => ['label' => 'Monthly Reports', 'iconClass' => ''],
                                    'quarterly_report' => ['label' => 'Quarterly Reports', 'iconClass' => '']
                                ]
                        ],
            'users' => ['label' => 'Users', 'iconClass' => 'entypo-users'],
            'settings' => ['label' => 'Settings', 'iconClass' => 'entypo-cog'],
        ];

        return $items;
    }

}
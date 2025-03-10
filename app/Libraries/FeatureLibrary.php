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

        $user_permitted_assemblies = service('session')->has('user_permitted_assemblies') ? service('session')->user_permitted_assemblies : [];
        $user_id = service('session')->user_id;

        $items = [
            "admin" => [
                'dashboards' => ['label' => 'dashboards', 'iconClass' => 'entypo-gauge', 'uri' => ''],
                'denominations' => ['label' => 'denominations', 'iconClass' => 'entypo-trophy', 'uri' => ''],
                'assemblies' => ['label' => 'assemblies', 'iconClass' => 'entypo-home', 'uri' => ''],
                'collections' => ['label' => 'collections', 'iconClass' => 'entypo-box', 'uri' => ''],
                'tithes' => ['label' => 'tithes', 'iconClass' => 'entypo-cup', 'uri' => ''],
                'ministers' => ['label' => 'ministers', 'iconClass' => 'entypo-book', 'uri' => ''],
                'members' => ['label' => 'members', 'iconClass' => 'entypo-database', 'uri' => ''],
                'events' => ['label' => 'events', 'iconClass' => 'entypo-layout', 'uri' => ''],
                'reports' => [
                                'label' => 'reports', 'iconClass' => 'entypo-newspaper', 'uri' => '',
                                'children' => $this->getReportTypeMenus()
                            ],
                'users' => ['label' => 'users', 'iconClass' => 'entypo-users', 'uri' => ''],
                'settings' => ['label' => 'settings', 'iconClass' => 'entypo-cog', 'uri' => ''],
            ],
            "church" => [
                'dashboards' => ['label' => 'my_dashboard', 'iconClass' => 'entypo-gauge', 'uri' => 'church/dashboards/list'],
                'assemblies' => count($user_permitted_assemblies) > 0 ? ['label' => 'my_assembly', 'iconClass' => 'entypo-home', 'uri' => 'church/assemblies/view/'.hash_id($user_permitted_assemblies,'encode')] : ['label' => 'my_assembly', 'iconClass' => 'entypo-home', 'uri' => 'church/assemblies/list'],
                'users' => ['label' => 'my_profile', 'iconClass' => 'entypo-users', 'uri' => 'church/users/view/'.hash_id($user_id, 'encode')],
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

    function getNameField($table){
        $nameField = 'name';

        if(class_exists("\\App\\Models\\".ucfirst($table).'Model')){
            $model = new ("\\App\\Models\\".ucfirst($table).'Model')();
            if(property_exists($model, 'nameField')){
                $nameField = $model->nameField;
            }
        }

        return $nameField;
    }

    function getFeatureTableNameById($featureId){
        $feature = new \App\Models\FeaturesModel();
        $featureData = $feature->find($featureId);
        return $featureData['feature_table_name'];
    }
}
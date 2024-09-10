<?php 

namespace App\Libraries;

class TemplateLibrary implements \App\Interfaces\LibraryInterface {


    function unsetListQueryFields(){

    }

    function unsetViewQueryFields(){

    }

    function setListQueryFields(){
        $fields = [];//['id','first_name','last_name','phone','email','gender','date_of_birth','event_id','payment_id','payment_code','registration_amount','status'];
        return $fields;
    }

    function setViewQueryFields(){
        $fields = []; // ['id','first_name','last_name','phone','email','gender','date_of_birth','event_id','payment_id','payment_code','registration_amount','status'];
        return $fields;
    }

    function getEmailTemplate(string $short_name, array $template_vars, int|null $denomination_id){
        $templateModel = new \App\Models\TemplatesModel();
        $template = $templateModel->where('short_name', $short_name)->first();

        if($template){
            $subject = $template['template_subject'];
            $body = $template['template_body'];

            foreach($template_vars as $key => $value){
                $body = str_replace('{{'.$key.'}}', $value, $body);
            }

            return compact('subject','body');
        }
    }
}
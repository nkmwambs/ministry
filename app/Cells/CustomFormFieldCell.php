<?php

namespace App\Cells;

use CodeIgniter\View\Cells\Cell;

class CustomFormFieldCell extends Cell
{
    public $field_code;
    public $field_type;
    public $field_options;
    public $field_name;
    public $field_value = '';
    public $field_id;
    public $form_values = [];
    private $component_view = 'custom_text_field';

    public function render(): string{
        if(in_array($this->field_type, ['date','text'])){
            $this->component_view = 'custom_text_field';
        }elseif(in_array($this->field_type, ['boolean','dropdown'])){
            $this->field_options = preg_split('/\r\n|\r|\n/', $this->field_options);
            $this->component_view = 'custom_select_field';
        }

        $params = [
            'field_code' => $this->field_code,
            'field_type' => $this->field_type,
            'field_options' => $this->field_options,
            'field_name' => $this->field_name,
            'field_value' => isset($this->form_values[$this->field_id]) ? $this->form_values[$this->field_id] : $this->field_value, // $this->field_value,
            'field_id' => $this->field_id,
        ];
        
        return view('components/'.$this->component_view, $params);
    }
}

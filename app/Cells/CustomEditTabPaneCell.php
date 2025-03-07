<?php

namespace App\Cells;

use CodeIgniter\View\Cells\Cell;

class CustomEditTabPaneCell extends Cell
{
    public $customFields;
    public $customValues;
    public $tab_pane_id;

    public function render(): string{
        $params = [
            'customFields' => $this->customFields,
            'customValues' => $this->customValues,
            'tab_pane_id' => $this->tab_pane_id,
        ];
        
        return view('components/custom_edit_tab_pane', $params);
    }
}

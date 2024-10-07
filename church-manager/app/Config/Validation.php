<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Validation\StrictRules\CreditCardRules;
use CodeIgniter\Validation\StrictRules\FileRules;
use CodeIgniter\Validation\StrictRules\FormatRules;
use CodeIgniter\Validation\StrictRules\Rules;

class Validation extends BaseConfig
{
    // --------------------------------------------------------------------
    // Setup
    // --------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var list<string>
     */
    public array $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public array $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    // --------------------------------------------------------------------
    // Rules
    // --------------------------------------------------------------------

    public $addEvent = [
            'name' => 'required|min_length[10]|max_length[255]',
            'meeting_id' => 'required',
            'location' => 'required|max_length[255]',
            'description' => 'required|max_length[255]',
            'denomination_id' => 'required',
    ];

    public $editEvent = [
        'name' => 'required|min_length[10]|max_length[255]',
        'meeting_id' => 'required',
        'location' => 'required|max_length[255]',
        'description' => 'required|max_length[255]',
        'denomination_id' => 'required',
    ];
}

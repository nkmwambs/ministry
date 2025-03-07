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
        'list' => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    // --------------------------------------------------------------------
    // Rules
    // --------------------------------------------------------------------

    public $registration = [
        'username' => [
            'label' => 'Auth.username',
            'rules' => [
                'required',
                'max_length[30]',
                'min_length[3]',
                'regex_match[/\A[a-zA-Z0-9\.]+\z/]',
                'is_unique[users.username]',
            ],
        ],
        // 'phone' => [
        //     'label' => 'Mobile Number',
        //     'rules' => [
        //         'max_length[20]',
        //         'min_length[10]',
        //         'regex_match[/\A[0-9]+\z/]',
        //         'is_unique[users.mobile_number]',
        //     ],
        // ],
        'email' => [
            'label' => 'Auth.email',
            'rules' => [
                'required',
                'max_length[254]',
                'valid_email',
                'is_unique[auth_identities.secret]',
            ],
        ],
        'password' => [
            'label' => 'Auth.password',
            'rules' => [
                'required',
                'max_byte[72]',
                'strong_password[]',
            ],
            'errors' => [
                'max_byte' => 'Auth.errorPasswordTooLongBytes',
            ]
        ],
        'password_confirm' => [
            'label' => 'Auth.passwordConfirm',
            'rules' => 'required|matches[password]',
        ],
    ];

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

    public $addCollection = [
        'sunday_date' => [
            'rules' => 'required',
            'label' => 'Sunday Date',
            'errors' => [
                'required' => '{field} is required.',
            ]
        ],
        'assembly_id' => [
            'rules' => 'required|numeric',
            'label' => 'Assembly Name',
            'errors' => [
                'required' => '{field} is required.',
                'numeric' => '{field} cannot be empty'
            ]
        ],
        'revenue_id.*' => [
            'rules' => 'required|numeric',
            'label' => 'Revenue Category',
            'errors' => [
                'required' => '{field} is required.',
                'numeric' => '{field} cannot be empty.'
            ]
        ],
        'amount.*' => [
            'rules' => 'required|numeric',
            'label' => 'Collection Amount',
            'errors' => [
                'required' => '{field} is required.',
                'numeric' => '{field} cannot be empty.'
            ]
        ],
        'sunday_count' => [
            'rules' => 'numeric',
            'label' => 'Sunday Date',
            'errors' => [
                'numeric' => 'The field {field} MUST be a Sunday.',
            ]
        ]
    ];

    public $addTithe = [
        'member_id.*' => [
            'rules' => 'required',
            'label' => 'Member Name',
            'errors' => [
                'required' => 'First Name is required.',
            ]
        ],
        'amount.*' => [
            'rules' => 'required',
            'label' => 'Tithe Amount',
            'errors' => [
                'required' => 'Tithe Amount is required.',
            ]
        ],
        'tithing_date' => [
            'rules' => 'required',
            'label' => 'Tithe Date',
            'errors' => [
                'required' => '{field} is required.',
            ]
        ],
        'assembly_id' => [
            'rules' => 'required',
            'label' => 'Assembly Name',
            'errors' => [
                'required' => '{field} is required.',
            ]
        ],
    ];

    public $addMember = [
        'first_name' => [
            'rules' => 'required|min_length[3]|max_length[255]',
            'label' => 'First Name',
            'errors' => [
                'required' => 'First Name is required.',
                'min_length' => 'First Name must be at least {value} characters long.',
            ]
        ],
        'last_name' => [
            'rules' => 'required|min_length[3]|max_length[255]',
            'label' => 'Last Name',
            'errors' => [
                'required' => 'Last Name is required.',
                'min_length' => 'Last Name must be at least {value} characters long.',
            ]
        ],
        'gender' => [
            'rules' => 'required',
            'label' => 'Member.member_gender',
            'errors' => [
                'required' => '{field} is required.',
            ]
        ],
        'date_of_birth' => [
            'rules' => 'required',
            'label' => 'Date of Birth',
            'errors' => [
                'required' => 'Date of Birth is required.',
            ]
        ],
        'phone' => [
            'rules' => 'required|regex_match[/^\+254\d{9}$/]',
            'label' => 'Phone',
            'errors' => [
                'regex_match' => 'Phone number should be in the format +254XXXXXXXX',
            ]
        ],
        'saved_date' => [
            'rules' => 'required',
            'label' => 'Date Saved',
            'errors' => [
                'required' => 'Date saved is required.',
            ]
        ],
        'assembly_id' => [
            'rules' => 'required',
            'label' => 'Assembly Name',
            'errors' => [
                'required' => 'Assembly Name is required.',
            ]
        ]

    ];
}

<?php

declare(strict_types=1);

/**
 * This file is part of CodeIgniter Shield.
 *
 * (c) CodeIgniter Foundation <admin@codeigniter.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Config;

use CodeIgniter\Shield\Config\AuthGroups as ShieldAuthGroups;

class AuthGroups extends ShieldAuthGroups
{
    /**
     * --------------------------------------------------------------------
     * Default Group
     * --------------------------------------------------------------------
     * The group that a newly registered user is added to.
     */
    public string $defaultGroup = 'member'; // Make sure this is available in the database

    /**
     * --------------------------------------------------------------------
     * Groups
     * --------------------------------------------------------------------
     * An associative array of the available groups in the system, where the keys
     * are the group names and the values are arrays of the group info.
     *
     * Whatever value you assign as the key will be used to refer to the group
     * when using functions such as:
     *      $user->addGroup('superadmin');
     *
     * @var array<string, array<string, string>>
     *
     * @see https://codeigniter4.github.io/shield/quick_start_guide/using_authorization/#change-available-groups for more info
     */
    public array $groups = [ // Do not remove the member group 
        'member' => [
            'title'       => 'Member',
            'description' => 'Complete control of the site.',
        ]
    ];

    /**
     * --------------------------------------------------------------------
     * Permissions
     * --------------------------------------------------------------------
     * The available permissions in the system.
     *
     * If a permission is not listed here it cannot be used.
     */
    public array $permissions = [];

    // public array $permissions = [
    //     'admin.access'        => 'Can access the sites admin area',
    //     'admin.settings'      => 'Can access the main site settings',
    //     'users.manage-admins' => 'Can manage other admins',
    //     'users.create'        => 'Can create new non-admin users',
    //     'users.edit'          => 'Can edit existing non-admin users',
    //     'users.delete'        => 'Can delete existing non-admin users',
    //     'beta.access'         => 'Can access beta-level features',
    // ];

    /**
     * --------------------------------------------------------------------
     * Permissions Matrix
     * --------------------------------------------------------------------
     * Maps permissions to groups.
     *
     * This defines group-level permissions.
     */
    public array $matrix = [
        // 'superadmin' => [
        //     'denomination.*',
        //     'dashboard.*',
        //     'hierarchy.*',
        //     'minister.*',
        //     'assembly.*',
        //     'member.*',
        //     'event.*',
        //     'participant.*',
        //     'visitor.*',
        //     'report.*',
        //     'user.*',
        //     'setting.*',
        //     'designation.*',
        //     'meeting.*',
        //     'department.*',
        //     'revenue.*',
        //     'field.*',
        //     'type.*',
        // ],
        // 'admin' => [
        //     // "dashboard.read",
        //     // "denomination.read",
        //     // "hierarchy.create",
        //     "assembly.update",
        //     // "minister.read",
        //     // "setting.read",
        //     // "department.read",
        //     // "minister.create",
        //     // "assembly.update",
        // ],
        // 'pastor' => [
        //     "assembly.read",
        //     "member.create",
        //     "collection.create",
        //     "report.update"
        // ],
        // 'treasurer' => [
        //     "assembly.read",
        //     "member.read",
        //     "collection.create",
        //     "report.update"
        // ],
        // 'member' => [
        //     'dashboard.read'
        // ],
        // 'beta' => [
        //     'beta.access',
        // ],
    ];


}

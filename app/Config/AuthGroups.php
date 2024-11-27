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
    public string $defaultGroup = 'member';

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
    public array $groups = [
        // 'superadmin' => [
        //     'title'       => 'Super Admin',
        //     'description' => 'Complete control of the site.',
        // ],
        // 'admin' => [
        //     'title'       => 'Ministry Admin',
        //     'description' => 'Day to day ministry administrators of the site.',
        // ],
        // 'pastor' => [
        //     'title'       => 'Assembly Pastor',
        //     'description' => 'Assembly pastor.',
        // ],
        // 'treasurer' => [
        //     'title'       => 'Assembly Treasurer',
        //     'description' => 'Assembly Treasurer.',
        // ],
        // 'member' => [
        //     'title'       => 'User',
        //     'description' => 'General users of the site. Often assembly members.',
        // ],
        // 'beta' => [
        //     'title'       => 'Beta User',
        //     'description' => 'Has access to beta-level features.',
        // ],
    ];

    /**
     * --------------------------------------------------------------------
     * Permissions
     * --------------------------------------------------------------------
     * The available permissions in the system.
     *
     * If a permission is not listed here it cannot be used.
     */
    public array $permissions = [
        // "dashboard.read" => "Dashboard", 
        // "hierarchy.create" => "Hierarchy", 
        // "hierarchy.read" => "Hierarchy", 
        // "hierarchy.update" => "Hierarchy", 
        // "hierarchy.delete" => "Hierarchy", 
        // "entity.create" => "Entity", 
        // "entity.read" => "Entity", 
        // "entity.update" => "Entity", 
        // "entity.delete" => "Entity", 
        // "assembly.create" => "Assembly", 
        // "assembly.read" => "Assembly", 
        // "assembly.update" => "Assembly", 
        // "assembly.delete" => "Assembly", 
        // "denomination.create" => "Denomination", 
        // "denomination.read" => "Denomination", 
        // "denomination.update" => "Denomination", 
        // "denomination.delete" => "Denomination", 
        // "collection.create" => "Collection", 
        // "collection.read" => "Collection", 
        // "collection.update" => "Collection", 
        // "collection.delete" => "Collection", 
        // "revenue.create" => "Revenue", 
        // "revenue.read" => "Revenue", 
        // "revenue.update" => "Revenue", 
        // "revenue.delete" => "Revenue", 
        // "designation.create" => "Designation", 
        // "designation.read" => "Designation", 
        // "designation.update" => "Designation", 
        // "designation.delete" => "Designation", 
        // "event.create" => "Events", 
        // "event.read" => "Events", 
        // "event.update" => "Events", 
        // "event.delete" => "Events", 
        // "meeting.create" => "Meetings", 
        // "meeting.read" => "Meetings", 
        // "meeting.update" => "Meetings", 
        // "meeting.delete" => "Meetings", 
        // "member.create" => "Members", 
        // "member.read" => "Members", 
        // "member.update" => "Members", 
        // "member.delete" => "Members", 
        // "participant.create" => "Participants", 
        // "participant.read" => "Participants", 
        // "participant.update" => "Participants", 
        // "participant.delete" => "Participants", 
        // "role.create" => "Roles", 
        // "role.read" => "Roles", 
        // "role.update" => "Roles", 
        // "role.delete" => "Roles", 
        // "subscription.create" => "Subscriptions", 
        // "subscription.read" => "Subscriptions", 
        // "subscription.update" => "Subscriptions", 
        // "subscription.delete" => "Subscriptions", 
        // "subscription_type.create" => "Subscription Types", 
        // "subscription_type.read" => "Subscription Types", 
        // "subscription_type.update" => "Subscription Types", 
        // "subscription_type.delete" => "Subscription Types", 
        // "user.create" => "Users", 
        // "user.read" => "Users", 
        // "user.update" => "Users", 
        // "user.delete" => "Users", 
        // "setting.read" => "Settings", 
        // "report.create" => "Reports", 
        // "report.read" => "Reports", 
        // "report.update" => "Reports", 
        // "report.delete" => "Reports", 
        // "type.create" => "Reports Types", 
        // "type.read" => "Reports Types", 
        // "type.update" => "Reports Types", 
        // "type.delete" => "Reports Types", 
        // "attendance.create" => "Meeting Attendance", 
        // "attendance.read" => "Meeting Attendance", 
        // "attendance.update" => "Meeting Attendance", 
        // "attendance.delete" => "Meeting Attendance", 
        // "field.create" => "Custom Fields", 
        // "field.read" => "Custom Fields", 
        // "field.update" => "Custom Fields", 
        // "field.delete" => "Custom Fields", 
        // "value.create" => "Custom values", 
        // "value.read" => "Custom values", 
        // "value.update" => "Custom values", 
        // "value.delete" => "Custom values", 
        // "department.create" => "Departments", 
        // "department.read" => "Departments", 
        // "department.update" => "Departments", 
        // "department.delete" => "Departments", 
        // "section.create" => "Report Sections", 
        // "section.read" => "Report Sections", 
        // "section.update" => "Report Sections", 
        // "section.delete" => "Report Sections", 
        // "visitor.create" => "Event Visitors", 
        // "visitor.read" => "Event Visitors", 
        // "visitor.update" => "Event Visitors", 
        // "visitor.delete" => "Event Visitors", 
        // "payment.read" => "Event payments", 
        // "minister.create" => "ministers", 
        // "minister.read" => "ministers", 
        // "minister.update" => "ministers", 
        // "minister.delete" => "ministers", 
        // "trash.read" => "trash", 
        // "task.create" => "Task", 
        // "task.read" => "Task", 
        // "task.update" => "Task", 
        // "task.delete" => "Task", 
        // "status.create" => "Status", 
        // "status.read" => "Status", 
        // "status.update" => "Status", 
        // "status.delete" => "Status" 
    ];

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

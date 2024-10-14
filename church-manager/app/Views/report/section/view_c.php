<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

<!-- <style>
  .toggle.ios, .toggle-on.ios, .toggle-off.ios { border-radius: 20px; }
  .toggle.ios .toggle-handle { border-radius: 20px; }
</style> -->

<?php
$fields = [
    'part_a' => [
        "title" => "",
        "field_data" => [
            'sermons' => [
                'type' => 'input',
                'label' => 'Sermons',
                'value' => '',
                'class' => '',
                'attributes' => [
                    'readonly' => 'readonly'
                ],
            ],
            'converted' => [
                'type' => 'input',
                'label' => 'Converted',
                'value' => '',
                'class' => '',
                'attributes' => [],
            ],
            'sanctified' => [
                'type' => 'input',
                'label' => 'Sanctified',
                'value' => '',
                'class' => '',
                'attributes' => [],
            ],
            'baptised' => [
                'type' => 'input',
                'label' => 'Baptised',
                'value' => '',
                'class' => '',
                'attributes' => [],
            ],
            'holy_ghost' => [
                'type' => 'input',
                'label' => 'Received Holy Ghost',
                'value' => '',
                'class' => '',
                'attributes' => [],
            ],
            'added_to_church' => [
                'type' => 'input',
                'label' => 'Added to Church',
                'value' => '',
                'class' => '',
                'attributes' => [],
            ],
            'fourth_sunday' => [
                'type' => 'input',
                'label' => 'Fourth Sunday',
                'value' => '',
                'class' => '',
                'attributes' => [],
            ],
            'prayer_meeting' => [
                'type' => 'input',
                'label' => 'Prayer Meeting',
                'value' => '',
                'class' => '',
                'attributes' => [],
            ],
            'homes_visited' => [
                'type' => 'input',
                'label' => 'Homes Visited',
                'value' => '',
                'class' => '',
                'attributes' => [],
            ],
            'tithes_to_local_church' => [
                'type' => 'input',
                'label' => 'Tithes Paid to Local Church',
                'value' => '',
                'class' => '',
                'attributes' => [],
            ],
            'total_amount_of_section_to_national_office' => [
                'type' => 'input',
                'label' => 'Total Amount of this section to the National office',
                'value' => '',
                'class' => '',
                'attributes' => [],
            ],
        ]
    ],
    'part_b' => [
        'title' => '',
        'field_data' => [
            'general_assembly_recommendations' => [
                'type' => 'yes/no',
                'label' => 'Do you boost the general assembly recommendations?',
                'value' => '',
                'class' => '',
                'attributes' => [],
            ],
            'number_revivals_this_month' => [
                'type' => 'yes/no',
                'label' => 'Number of revivals conducted this month?',
                'value' => '',
                'class' => '',
                'attributes' => [],
            ],
            'number_revivals_this_week' => [
                'type' => 'yes/no',
                'label' => 'Number of revivals conducted this week?',
                'value' => '',
                'class' => '',
                'attributes' => [],
            ],
            'number_revivals_in_weekdays' => [
                'type' => 'yes/no',
                'label' => 'Number of revivals conducted in weekdays?',
                'value' => '',
                'class' => '',
                'attributes' => [],
            ],
            'place_of_conduct' => [
                'type' => 'yes/no',
                'label' => 'Where did you conduct this?',
                'value' => '',
                'class' => '',
                'attributes' => [],
            ],
            'full_time_minister' => [
                'type' => 'yes/no',
                'label' => 'Are you full time minister?',
                'value' => '',
                'class' => '',
                'attributes' => [],
            ],
            'number_of_prayer_meeting' => [
                'type' => 'yes/no',
                'label' => 'Number of new home prayer meeting conducted by you?',
                'value' => '',
                'class' => '',
                'attributes' => [],
            ],
            'family_workship' => [
                'type' => 'yes/no',
                'label' => 'Do you have daily family workship?',
                'value' => '',
                'class' => '',
                'attributes' => [],
            ],
        ],
    ]
];

$checkbox_fields = [
    'licence_held' => [
        'type' => 'yes/no',
        'label' => 'Licence held',
        'value' => '',
        'class' => '',
        'attributes' => []
    ],
    'bishop' => [
        'type' => 'yes/no',
        'label' => 'Bishop',
        'value' => '',
        'class' => '',
        'attributes' => [],
    ],
    'evangelist' => [
        'type' => 'yes/no',
        'label' => 'Evangelist',
        'value' => '',
        'class' => '',
        'attributes' => [],
    ],
    'lay_minister' => [
        'type' => 'yes/no',
        'label' => 'Lay Minister',
        'value' => '',
        'class' => '',
        'attributes' => [],
    ]
];
?>

<div class="row">
    <div class="col-xs-12 center heading">
        PART 3: MINISTER'S REPORT
    </div>
</div>

<form class="form-horizontal form-groups-bordered" role="form">

    <div class="form-group">
        <?php foreach ($checkbox_fields as $name => $field): ?>
            <label class="switcher">
                <span class="switcher-label"><?= $field['label'] ?></span>
                <input type="checkbox" class="switcher-input <?= $field['class'] ?>" name="<?= $name ?>" value="<?= $field['value'] ?>"
                    <?php foreach ($field['attributes'] as $key => $value) echo "$key='$value' "; ?>>
                <span class="switcher-indicator">
                    <span class="switcher-yes"></span>
                    <span class="switcher-no"></span>
                </span>
            </label>
        <?php endforeach; ?>
    </div>

    <!-- <div class="form-group">
        <label class="switcher">
            <span class="switcher-label">Licence held</span>
            <input type="checkbox" class="switcher-input">
            <span class="switcher-indicator">
                <span class="switcher-yes"></span>
                <span class="switcher-no"></span>
            </span>
        </label>
        <label class="switcher">
            <span class="switcher-label">Bishop</span>
            <input type="checkbox" class="switcher-input">
            <span class="switcher-indicator">
                <span class="switcher-yes"></span>
                <span class="switcher-no"></span>
            </span>
        </label>
        <label class="switcher">
            <span class="switcher-label">Evangelist</span>
            <input type="checkbox" class="switcher-input">
            <span class="switcher-indicator">
                <span class="switcher-yes"></span>
                <span class="switcher-no"></span>
            </span>
        </label>
        <label class="switcher">
            <span class="switcher-label">Lay Minister</span>
            <input type="checkbox" class="switcher-input">
            <span class="switcher-indicator">
                <span class="switcher-yes"></span>
                <span class="switcher-no"></span>
            </span>
        </label>
    </div> -->

    <?php foreach ($fields as $part) { ?>
        <div class="row">
            <div class="col-xs-6">
                <div class="form-group" style="text-align:center;">
                    <label class="control-label"><?= $part['title']; ?></label>
                </div>
                <?php
                foreach ($part['field_data'] as $id => $metadata) {
                    $attributes = '';
                    foreach ($metadata['attributes'] as $attr_id => $attr_value) {
                        $attributes .= $attr_id . '="' . $attr_value . '" ';
                    }
                ?>
                    <div class="form-group">
                        <label for="" class="control-label col-xs-4"><?= $metadata['label']; ?></label>
                        <div class="col-xs-6">
                            <div class="form_view_field">
                                <?php if ($metadata['type'] == 'input') { ?>
                                    <input class="form-control <?= $metadata['class']; ?>" <?= $attributes; ?> name="<?= $id; ?>" id="<?= $id; ?>" />
                                <?php } else { ?>
                                    <input type="checkbox" name="<?= $id; ?>" id="<?= $id; ?>" data-toggle="toggle" data-on="Yes" data-off="No">
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>

            </div>

        <?php } ?>

</form>
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

<?php

$fields = [
    'part_a' => [
        "title" => "SECTION ONE: Report to National Office",
        "field_data" => [
            'tenth_of_total_tithes_to_national_office' => [
                'type' => 'input',
                'label' => '10% total Tithes to National Office',
                'value' => '',
                'class' => '',
                'attributes' => [
                    'readonly' => 'readonly',
                ],
            ],
            'revival_this_month' => [
                'type' => 'yes/no',
                'label' => 'Revival This Month',
                'value' => '',
                'class' => '',
                'attributes' => [],
            ],
            'harvest_and_leadership_development_offering' => [
                'type' => 'input',
                'label' => 'Harvest and Leadership Development Offering',
                'value' => 'Yes',
                'class' => '',
                'attributes' => [
                    'readonly' => 'readonly',
                ],
            ],
            'fourth_sunday' => [
                'type' => 'yes/no',
                'label' => 'Fourth Sunday',
                'value' => '',
                'class' => '',
                'attributes' => [],
            ],
            'other_monies_sent_to_national_treasurer' => [
                'type' => 'input',
                'label' => 'Other Monies Sent to National Treasurer',
                'value' => '',
                'class' => '',
                'attributes' => [
                    'readonly' => 'readonly',
                ],
            ],
            'total_amount_of_section_one_to_national_treasurer' => [
                'type' => 'input',
                'label' => 'Total Amount of Section One to National Treasurer',
                'value' => '',
                'class' => '',
                'attributes' => [
                    'readonly' => 'readonly',
                ],
            ]
        ],
    ],
    'part_b' => [
        "title" => "SECTION TWO: Report to International Office",
        "field_data" => [
            'tenth_of_total_tithes_to_international_office' => [
                'type' => 'input',
                'label' => '10% total Tithes to International Office',
                'value' => '',
                'class' => '',
                'attributes' => [
                    'readonly' => 'readonly',
                ],
            ],
            'second_sunday' => [
                'type' => 'yes/no',
                'label' => 'Second Sunday',
                'value' => '',
                'class' => '',
                'attributes' => [],
            ],
            'other_monies_sent_to_international_treasurer' => [
                'type' => 'input',
                'label' => 'Other Monies sent to International Treasurer',
                'value' => '',
                'class' => '',
                'attributes' => [
                    'readonly' => 'readonly',
                ],
            ],
            'total_amount_of_section_one_to_international_treasurer' => [
                'type' => 'yes/no',
                'label' => 'Total Amount of Section One sent to International Treasurer',
                'value' => '',
                'class' => '',
                'attributes' => [],
            ],
        ],
    ],
];
?>

<div class="row">
    <div class="col-xs-12 center heading">
        PART 2: TREASURER'S FINANCIAL REPORT
    </div>
</div>

<form class="form-horizontal form-groups-bordered" role="form">

    <!-- <div class="form-group">
        <label for="" class="control-label col-xs-4">Total Tithes from Local Church</label>
        <div class="col-xs-6">
            <div class="form_view_field">200,000</div>
        </div>
    </div> -->

    <?php foreach ($fields as $section) { ?>
        <div class="row">
            <div class="col-xs-6">
                <div class="form-group" style="text-align:center">
                    <label for="" class="control-label"><?= $section['title']; ?></label>
                </div>
                <?php
                foreach ($section['field_data'] as $id => $metadata) {
                    $attributes = '';
                    foreach ($metadata['attributes'] as $attr => $value) {
                        $attributes .= $attr . '="' . $value . '" ';
                    }
                ?>
                    <div class="form-group">
                        <label for="" class="control-label col-xs-4"><?= $metadata['label']; ?></label>
                        <div class="col-xs-6">
                            <div class="form_view_field">
                                <?php if ($metadata['type'] == 'input') { ?>
                                    <input class="form-control <?= $metadata['class']; ?>" name="<?= $id; ?>" id="<?= $id; ?>" <?= $attributes; ?>>
                                <?php } else { ?>
                                    <input type="checkbox" name="<? $id; ?>" id="<?= $id; ?>" data-toggle="toggle" data-on="Yes" data-off="No">
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    <?php } ?>

</form>
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<style>
  .toggle.ios, .toggle-on.ios, .toggle-off.ios { border-radius: 20px; }
  .toggle.ios .toggle-handle { border-radius: 20px; }
</style>
<?php 
$fields = [
    'part_a' => [
        "title" => "Membership",
        "field_data" => [
            'total_membership' => [
            'type' => 'input',
            'label' => 'Total Membership',
            'value' => '',
            'class' => '',
            'attributes' => [
                'readonly' => 'readonly'
            ],
        ],
        'number_saved' => [
            'type' => 'input',
            'label' => 'Number Saved',
            'value' => '',
            'class' => '',
            'attributes' => [],
        ],
        'number_sanctified' => [
            'type' => 'input',
            'label' => 'Number Sanctified',
            'value' => '',
            'class' => '',
            'attributes' => [],
        ],
        'number_baptised_of_holy_ghost' => [
            'type' => 'input',
            'label' => 'Number filled with Holy Ghost',
            'value' => '',
            'class' => '',
            'attributes' => [],
        ],
        'number_baptised_of_water' => [
            'type' => 'input',
            'label' => 'Number Baptised of Water',
            'value' => '',
            'class' => '',
            'attributes' => [],
        ],
        'number_transfered_away' => [
            'type' => 'input',
            'label' => 'Number Transfered Away',
            'value' => '',
            'class' => '',
            'attributes' => [],
        ],
        'number_transfered_in' => [
            'type' => 'input',
            'label' => 'Number Transfered In',
            'value' => '',
            'class' => '',
            'attributes' => [],
        ],
        'number_deceased' => [
            'type' => 'input',
            'label' => 'Number Of Deceased',
            'value' => '',
            'class' => '',
            'attributes' => [],
        ],
        'number_added' => [
            'type' => 'input',
            'label' => 'Number Of Added',
            'value' => '',
            'class' => '',
            'attributes' => [],
        ],
        'number_excluded' => [
            'type' => 'input',
            'label' => 'Number Of Excluded',
            'value' => '',
            'class' => '',
            'attributes' => [],
        ],
        'avg_sunday_school_attendance' => [
            'type' => 'input',
            'label' => 'Average Sunday School Attendance',
            'value' => '',
            'class' => '',
            'attributes' => [],
        ],
        'number_weekly_attendance' => [
            'type' => 'input',
            'label' => 'Number of weekly Attendance',
            'value' => '',
            'class' => '',
            'attributes' => [],
        ],
        'proportion_children_youth_attendance' => [
            'type' => 'input',
            'label' => 'Proportion of Children and Youth Attendance',
            'value' => '',
            'class' => '',
            'attributes' => [],
        ],
        'enclosed_news' => [
            'type' => 'yes/no',
            'label' => 'Enclosed any news to share?',
            'value' => '',
            'class' => '',
            'attributes' => [],
        ],
        ]
    ],
    'part_b' => [
        'title' => 'Are these Auxillaries operating in the local Church?',
        'field_data' => [
            'department_pastoral_care' => [
                'type' => 'yes/no',
                'label' => 'Department of Pastoral Care',
                'value' => '',
                'class' => '',
                'attributes' => [],
            ],
            'youth_ministry' => [
                'type' => 'yes/no',
                'label' => 'Youth Ministries',
                'value' => '',
                'class' => '',
                'attributes' => [],
            ],
            'children_ministry' => [
                'type' => 'yes/no',
                'label' => 'Children Ministries',
                'value' => '',
                'class' => '',
                'attributes' => [],
            ],
            'sunday_school_education' => [
                'type' => 'yes/no',
                'label' => 'Sunday School (Christian Education)',
                'value' => '',
                'class' => '',
                'attributes' => [],
            ],
            'women_ministries' => [
                'type' => 'yes/no',
                'label' => 'Women Ministries',
                'value' => '',
                'class' => '',
                'attributes' => [],
            ],
            'first_sunday_offering' => [
                'type' => 'yes/no',
                'label' => 'First Sunday Offering',
                'value' => '',
                'class' => '',
                'attributes' => [],
            ],
            'second_sunday_missions' => [
                'type' => 'yes/no',
                'label' => 'Second Sunday Missions',
                'value' => '',
                'class' => '',
                'attributes' => [],
            ],
            'fourth_sunday' => [
                'type' => 'yes/no',
                'label' => 'Fourth Sunday',
                'value' => '',
                'class' => '',
                'attributes' => [],
            ],
            'revival_month' => [
                'type' => 'yes/no',
                'label' => 'Revival This Month',
                'value' => '',
                'class' => '',
                'attributes' => [],
            ],
            'bible_study_training' => [
                'type' => 'yes/no',
                'label' => 'Number of Bible Study/Training Programmes this month',
                'value' => '',
                'class' => '',
                'attributes' => [],
            ]
        ]
    ]
];
?>

<div class="row">
    <div class="col-xs-12 center heading">
        PART 1: PASTOR'S LOCAL CHURCH REPORT
    </div>
</div>

<form class="form-horizontal form-groups-bordered" role="form">

    <?php foreach($fields as $part){?>
    <div class="row">
        <div class="col-xs-6">
            <div class="form-group" style="text-align:center;">
                <label class="control-label"><?=$part['title'];?></label>
            </div>
        <?php 
            foreach($part['field_data'] as $id => $metadata){
                $attributes = '';
                foreach($metadata['attributes'] as $attr_id => $attr_value){
                    $attributes.= $attr_id.'="'.$attr_value.'" ';
                }        
        ?>
            <div class="form-group">
                <label for="" class="control-label col-xs-4"><?=$metadata['label'];?></label>
                <div class="col-xs-6">
                    <div class="form_view_field">
                        <?php if($metadata['type'] == 'input'){?>
                            <input class = "form-control <?=$metadata['class'];?>" <?=$attributes;?> name="<?=$id;?>" id = "<?=$id;?>" />
                        <?php }else{?>
                            <input type="checkbox" name="<?=$id;?>" id = "<?=$id;?>" data-toggle="toggle"  data-on="Yes" data-off="No">
                        <?php }?>
                    </div>
                </div>
            </div>
        <?php }?>
           
        </div>

    <?php }?>

</form>
<!-- </div> -->

<script>
    $(document).ready(function() {
    })
</script>
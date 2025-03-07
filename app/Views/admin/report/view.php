<?php 
    
    echo report_template([
        'type_name' => $report_type_name, 
        'type_code' => $type_code, 
        'requires_mobile_money' => $requires_mobile_money,
        'remittance_amount_builder' => $remittance_amount_builder,
        'assembly_name' => $assembly_name,
    ],$report_fields, $report_period);
<style>
    .section_title {
        font-weight: bold;
        text-align: center;
        font-size: 14pt;
    }

    .part_title {
        font-weight: bold;
        text-align: center;
        text-decoration: underline;
        margin-top: 10px;
        margin-bottom: 10px;
    }
</style>
<div class="row">
    <div class="col-md-12">

        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <div class="page-title">
                        <i class='fa fa-eye'></i><?= lang('type.view_type'); ?>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <form  class="form-horizontal form-groups-bordered">
                    <div class = "form-group">
                        <div class="col-xs-4">
                            <label><?= lang('type.type_name') ?></label>
                        </div>
                        <div class = "col-xs-8">
                            <?=$result['name'];?>
                        </div>
                    </div>

                    <div class = "form-group">
                        <div class="col-xs-4">
                            <label><?= lang('denomination.denomination_name') ?></label>
                        </div>
                        <div class = "col-xs-8">
                            <?=$result['denomination_name'];?>
                        </div>
                    </div>

                    <div class = "form-group">
                        <div class="col-xs-4">
                            <label><?= lang('type.scheduler') ?></label>
                        </div>
                        <div class = "col-xs-8">
                            <?=$result['scheduler'];?>
                        </div>
                    </div>

                            <?php 
                                $report_layout = json_decode($result['report_layout'], true);
                                if(!empty($report_layout)){
                                    foreach($report_layout as $section){
                            ?>

                                <div class = "form-group">
                                    
                                    <div class="col-xs-12 section_title">
                                        <?=$section['section_title'];?>
                                    </div>

                                    <div class="panel-group joined" id="accordion-test-2">    
                                        <?php  
                                            if(isset($section['section_parts'])){ 
                                            $cnt = 0;
                                            foreach($section['section_parts'] as $part){
                                        ?>
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title">
                                                        <a data-toggle="collapse" data-parent="#accordion-test-2" href="#collapse-<?=$cnt;?>">
                                                            <?=$part['part_title'];?>
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="collapse-<?=$cnt;?>" class="panel-collapse collapse">
                                                    <div class="panel-body">
                                                        <?php if(isset($part['part_fields'])){
                                                            $part_fields = explode(',',$part['part_fields'][0]);
                                                            echo view("admin/type/type_view_table", compact('part_fields'));
                                                         } ?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php 
                                                $cnt++;
                                            } 
                                        }
                                        ?>
                                    </div> 

                                </div>  

                            <?php
                                    }
                                }

                            ?>
                </form>
            </div>

        </div>
    </div>
</div>


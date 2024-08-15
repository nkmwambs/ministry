<div class="row">
    <div class="col-xs-12 btn-container">
        <a href="<?= site_url("denominations"); ?>" class="btn btn-info">Back</a>
    </div>
</div>

<div class = "row">
    <?php if(session()->getFlashdata('message') ){?>
        <div class = "col-xs-12 info">
            <p><?= session()->getFlashdata('message');?></p>
            <a href="<?= site_url(plural($feature).'/edit/' . $id) ?>">Edit Again</a>
        </div>
    <?php }?>
</div>

<div class="row">
    <div class="col-md-12">

        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <div class="page-title">
                        <i class='fa fa-eye'></i><?= lang('denomination.view_denomination'); ?>
                    </div>
                    <div class="panel-options">
							
							<ul class="nav nav-tabs">
								<li class="active"><a href="#view_denomination" id="view_denomination_tab" data-toggle="tab"><?= lang('denomination.view_denomination'); ?></a></li>
								<li><a href="#list_hierarchies" id="list_hierarchies_tab" data-toggle="tab"><?= lang('hierarchy.list_hierarchies'); ?></a></li>
							</ul>
					</div>
                </div>
            </div>
            <div class="panel-body">
                
                <div class="tab-content">
                    <div class="tab-pane active" id="view_denomination">
                        <form class="form-horizontal form-groups-bordered" role="form">
                            <?php foreach($result as $field_name => $field_value){ ?>
                                <div class = "form-group">
                                    <label for="" class = "control-label col-xs-4"><?=humanize($field_name);?></label>
                                    <div class = "col-xs-6">
                                        <div class = "form_view_field"><?=$field_value;?></div>
                                    </div>
                                </div>
                            <?php } ?>
            
                            <div class = "form-group">
                                <div class = "col-xs-offset-4 col-xs-6">
                                    <a href="<?= site_url(plural($feature).'/edit/' . $id) ?>" class="btn btn-primary">Edit</a>
                                </div>
                            </div> 
                        </form>
                    </div>

                    <div class="tab-pane" id="list_hierarchies">
                        <div class = 'info'>There are not hierarchies available</div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('#list_hierarchies_tab').on('click', function() {
            const url = "<?= site_url('hierarchies/'.$id);?>";

            getRequest(url, function(response) {
                $('#list_hierarchies').html(response);
            });
        })
    }); 
</script>
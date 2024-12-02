
<style>
    .scrollable-view {
    overflow-x: auto; /* Enable horizontal scrolling */
    white-space: nowrap; /* Prevent content from wrapping */
    padding: 10px; /* Optional: Adjust for spacing */
    border: 1px solid #ccc; /* Optional: Add border for clarity */
}
</style>


<div class="row">
    <?php if (session()->getFlashdata('message')) { ?>
        <div class="col-xs-12 info">
            <p><?= session()->getFlashdata('message'); ?></p>
            <a href="<?= site_url(plural($feature) . '/edit/' . $id) ?>">Edit Again</a>
        </div>
    <?php } ?>
</div>

<div class="row">
    <div class="col-md-12">

        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <div class="page-title">
                        <i class='fa fa-eye'></i><?= lang('assembly.view_assembly'); ?>
                    </div>
                    <div class="panel-options">

                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#list_members" data-parent_id="<?=$id?>" data-parent_table="assemblies" data-link_id="list_members"
                                    data-feature="member" data-table_id = "table_list_members" class = "view_tabs" id="list_members_tab"
                                    data-toggle="tab"><?= lang('member.list_members'); ?></a></li>
                            <li><a href="#list_collections" data-parent_id="<?=$id?>" data-table_id = "table_list_collections" data-parent_table="assemblies" data-link_id="list_collections"
                                    data-feature="collection"  class = "view_tabs"
                                    id="list_collections_tab"
                                    data-toggle="tab"><?= lang('collection.list_collections'); ?></a></li>
                            <li><a href="#list_tithes" data-parent_id="<?=$id?>" data-link_id="list_tithes" data-feature="tithe"
                                     id="list_tithes_tab" class = "view_tabs" data-parent_table="assemblies" data-table_id = "table_list_tithes"
                                    data-toggle="tab"><?= lang('tithe.list_tithes'); ?></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="panel-body">

                <div class="tab-content">

                    <div class="active tab-pane scrollable-view" id="list_members">
                        <?=datatable("table_list_members", 'member', $columns['member'],$id);?>
                    </div>

                    <div class="tab-pane" id="list_collections">
                        <?=datatable("table_list_collections", 'collection',$columns['collection'],$id);?>
                    </div>

                    <div class="tab-pane" id="list_tithes">
                        <?=datatable("table_list_tithes", 'tithe',$columns['tithe'],$id);?>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $(".nav-tabs").find("li.active").find('a').click();
        
    });
</script>
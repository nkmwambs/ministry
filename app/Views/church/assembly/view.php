<div class="row">
    <div class="col-xs-12 btn-container">
        <div class="btn btn-info btn_back">
            <?= lang('report.back_button') ?>
        </div>
    </div>
</div>

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

                        <ul class="nav nav-tabs" id="myTabs">
                            <li class="active"><a href="#list_members" data-item_id="" data-link_id="list_members"
                                    data-feature="member" onclick="loadDatatableOnTabs(this)" id="list_members_tab"
                                    data-toggle="tab"><?= lang('member.list_members'); ?></a></li>
                            <li><a href="#list_collections" data-item_id="" data-link_id="list_collections"
                                    data-feature="collection" onclick="loadDatatableOnTabs(this)"
                                    id="list_collections_tab"
                                    data-toggle="tab"><?= lang('collection.list_collections'); ?></a></li>
                            <li><a href="#list_tithes" data-item_id="" data-link_id="list_tithes" data-feature="tithe"
                                    onclick="loadDatatableOnTabs(this)" id="list_tithes_tab"
                                    data-toggle="tab"><?= lang('tithe.list_tithes'); ?></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="panel-body">

                <div class="tab-content">

                    <div class="active tab-pane" id="list_members">
                        <?=datatable("table_list_members", $columns['member']);?>
                    </div>

                    <div class="tab-pane" id="list_collections">
                        <?=datatable("table_list_collections", $columns['collection']);?>
                    </div>

                    <div class="tab-pane" id="list_tithes">
                        <?=datatable("table_list_tithes", $columns['tithe']);?>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
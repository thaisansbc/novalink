<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>


<?php
$v = '&customer=' . $user_id;
if ($this->input->post('submit_sale_report')) {
    if ($this->input->post('biller')) {
        $v .= '&biller=' . $this->input->post('biller');
    }
    if ($this->input->post('warehouse')) {
        $v .= '&warehouse=' . $this->input->post('warehouse');
    }
    if ($this->input->post('user')) {
        $v .= '&user=' . $this->input->post('user');
    }
    if ($this->input->post('serial')) {
        $v .= '&serial=' . $this->input->post('serial');
    }
     if ($this->input->post('saleman_by')) {
            $v .= '&saleman_by=' . $this->input->post('saleman_by');
        }
    if ($this->input->post('start_date')) {
        $v .= '&start_date=' . $this->input->post('start_date');
    }
    if ($this->input->post('end_date')) {
        $v .= '&end_date=' . $this->input->post('end_date');
    }
}
?>
<script>
$(document).ready(function () {
    oTable = $('#SlRData').dataTable({
        "aaSorting": [[0, "desc"]],
        "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "<?= lang('all') ?>"]],
        "iDisplayLength": <?= $Settings->rows_per_page ?>,
        'bProcessing': true, 'bServerSide': true,
        'sAjaxSource': '<?= admin_url('reports/getBVSalesReport/?v=1' . $v) ?>',
        'fnServerData': function (sSource, aoData, fnCallback) {
            aoData.push({
                "name": "<?= $this->security->get_csrf_token_name() ?>",
                "value": "<?= $this->security->get_csrf_hash() ?>"
            });
            $.ajax({'dataType': 'json', 'type': 'POST', 'url': sSource, 'data': aoData, 'success': fnCallback});
        },
        'fnRowCallback': function (nRow, aData, iDisplayIndex) {
            nRow.id = aData[7];
            nRow.className = (aData[7] > 0) ? "invoice_link2" : "invoice_link2 warning";
            return nRow;
        },
        "aoColumns": [
            {"mRender": fld}, 
            null, 
            null, 
            null, 
            null, 
            null,
            {"mRender": formatQuantity,"sClass":"center"},
            {"mRender": formatQuantity,"sClass":"center"}
        ],
        "fnFooterCallback": function (nRow, aaData, iStart, iEnd, aiDisplay) {
            var totalqty = 0,totalbv=0;
            for (var i = 0; i < aaData.length; i++) {
                totalqty += parseFloat(aaData[aiDisplay[i]][6]);
                totalbv += parseFloat(aaData[aiDisplay[i]][7]);
            }
            var nCells = nRow.getElementsByTagName('th');
            nCells[6].innerHTML = parseFloat(totalqty);
            nCells[7].innerHTML = parseFloat(totalbv);
        }
    }).fnSetFilteringDelay().dtFilter([
        {column_number: 0, filter_default_label: "[<?=lang('date');?> (yyyy-mm-dd)]", filter_type: "text", data: []},
        {column_number: 1, filter_default_label: "[<?=lang('reference_no');?>]", filter_type: "text", data: []},
        {column_number: 2, filter_default_label: "[<?=lang('biller');?>]", filter_type: "text", data: []},
        {column_number: 3, filter_default_label: "[<?=lang('customer');?>]", filter_type: "text", data: []},
        {column_number: 4, filter_default_label: "[<?=lang('saleman');?>]", filter_type: "text", data: []},
        {column_number: 5, filter_default_label: "[<?=lang('product_name');?>]", filter_type: "text", data: []},
    ], "footer");
});
</script>
<script type="text/javascript">
$(document).ready(function () {
    $('#form').hide();
    $('.toggle_down').click(function () {
        $("#form").slideDown();
        return false;
    });
    $('.toggle_up').click(function () {
        $("#form").slideUp();
        return false;
    });
});
</script>

<div class="box sales-table">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-heart nb"></i><?= lang('customer_sales_report'); ?> <?php
        if ($this->input->post('start_date')) {
            echo 'From ' . $this->input->post('start_date') . ' to ' . $this->input->post('end_date');
        }
        ?></h2>
        <div class="box-icon">
            <ul class="btn-tasks">
                <li class="dropdown">
                    <a href="#" class="toggle_up tip" title="<?= lang('hide_form') ?>">
                        <i class="icon fa fa-toggle-up"></i>
                    </a>
                </li>
                <li class="dropdown">
                    <a href="#" class="toggle_down tip" title="<?= lang('show_form') ?>">
                        <i class="icon fa fa-toggle-down"></i>
                    </a>
                </li>
            </ul>
        </div>
        <div class="box-icon">
            <ul class="btn-tasks">
                <li class="dropdown">
                    <a href="#" id="xls" class="tip" title="<?= lang('download_xls') ?>">
                        <i class="icon fa fa-file-excel-o"></i>
                    </a>
                </li>
                <li class="dropdown">
                    <a href="#" id="image" class="tip" title="<?= lang('save_image') ?>">
                        <i class="icon fa fa-file-picture-o"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">
                <p class="introtext"><?= lang('customize_report'); ?></p>
                <div id="form">
                    <?php echo admin_form_open('reports/saleman_bv_report/' . $user_id); ?>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label" for="user"><?= lang('created_by'); ?></label>
                                <?php
                                $us[''] = lang('select') . ' ' . lang('user');
                                foreach ($users as $user) {
                                    $us[$user->id] = $user->first_name . ' ' . $user->last_name;
                                }
                                echo form_dropdown('user', $us, (isset($_POST['user']) ? $_POST['user'] : ''), 'class="form-control" id="user" data-placeholder="' . $this->lang->line('select') . ' ' . $this->lang->line('user') . '"');
                                ?>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label" for="biller"><?= lang('biller'); ?></label>
                                <?php
                                $bl[''] = lang('select') . ' ' . lang('biller');
                                foreach ($billers as $biller) {
                                    $bl[$biller->id] = $biller->company && $biller->company != '-' ? $biller->company : $biller->name;
                                }
                                echo form_dropdown('biller', $bl, (isset($_POST['biller']) ? $_POST['biller'] : ''), 'class="form-control" id="biller" data-placeholder="' . $this->lang->line('select') . ' ' . $this->lang->line('biller') . '"');
                                ?>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label" for="saleman_by"><?= lang('saleman'); ?></label>
                                <?php
                                $sm[''] = lang('select') . ' ' . lang('saleman');
                                foreach ($salemans as $saleman) {
                                    $sm[$saleman->id] = $saleman->first_name . ' ' . $saleman->last_name;
                                }
                                echo form_dropdown('saleman_by', $sm, (isset($_POST['saleman_by']) ? $_POST['saleman_by'] : ''), 'class="form-control" id="saleman_by" data-placeholder="' . $this->lang->line('select') . ' ' . $this->lang->line('saleman') . '"');
                                ?>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label" for="warehouse"><?= lang('warehouse'); ?></label>
                                <?php
                                $wh[''] = lang('select') . ' ' . lang('warehouse');
                                foreach ($warehouses as $warehouse) {
                                    $wh[$warehouse->id] = $warehouse->name;
                                }
                                echo form_dropdown('warehouse', $wh, (isset($_POST['warehouse']) ? $_POST['warehouse'] : ''), 'class="form-control" id="warehouse" data-placeholder="' . $this->lang->line('select') . ' ' . $this->lang->line('warehouse') . '"');
                                ?>
                            </div>
                        </div>
                        <?php if ($Settings->product_serial) {
                                    ?>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <?= lang('serial_no', 'serial'); ?>
                                    <?= form_input('serial', '', 'class="form-control tip" id="serial"'); ?>
                                </div>
                            </div>
                            <?php
                                } ?>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <?= lang('start_date', 'start_date'); ?>
                                    <?php echo form_input('start_date', (isset($_POST['start_date']) ? $_POST['start_date'] : ''), 'class="form-control datetime" id="start_date"'); ?>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <?= lang('end_date', 'end_date'); ?>
                                    <?php echo form_input('end_date', (isset($_POST['end_date']) ? $_POST['end_date'] : ''), 'class="form-control datetime" id="end_date"'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div
                            class="controls"> <?php echo form_submit('submit_sale_report', $this->lang->line('submit'), 'class="btn btn-primary"'); ?> </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                    <div class="clearfix"></div>
                    <div class="table-responsive">
                        <table id="SlRData"
                        class="table table-hover table-striped table-condensed reports-table reports-table">
                        <thead>
                            <tr>
                                <th style="width: 150px;"><?= lang('date'); ?></th>
                          
                                <th style="width: 150px;"><?= lang('reference_no'); ?></th>
                                <th style="width: 250px;"><?= lang('biller'); ?></th>
                                <th style="width: 150px;"><?= lang('customer'); ?></th>
                                <th style="width: 150px;"><?= lang('saleman'); ?></th>
                                <th><?= lang('product_name'); ?></th>
                                <th><?= lang('product_qty'); ?></th>
                                <th><?= lang('total_bv'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="7" class="dataTables_empty"><?= lang('loading_data_from_server') ?></td>
                            </tr>
                        </tbody>
                        <tfoot class="dtFilter">
                            <tr class="active">
                                <th style="width: 50px;"></th>
                                <th></th>
                                <th style="width: 50px;"></th>
                                <th style="width: 50px;"></th>
                                <th style="width: 40px;"></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>



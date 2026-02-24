<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-2x">&times;</i>
            </button>
            <h4 class="modal-title" id="myModalLabel"><?php echo lang('activate'); ?></h4>
        </div>
        <?php $attrib = ['data-toggle' => 'validator', 'role' => 'form'];
        echo admin_form_open('auth/activate_saleman/' . $user->id, $attrib); ?>
        <div class="modal-body">
            <p><?php echo sprintf(lang('Are you sure to deactivate the user?'), $user->last_name); ?></p>
            <div class="row">

                <div class="col-sm-12">
                    <div class="form-group">
                        <label class="checkbox" for="confirm">
                            <input type="checkbox" name="confirm" value="yes" checked="checked" id="confirm"/> <?= lang('yes') ?></label>
                    </div>
                </div>
                <div class="col-sm-4">                              
                    <div class="form-group">
                        <?= lang("amount", "amount"); ?>
                        <input name="amount" value="18" type="text" class="form-control"/>                                
                    </div>                                
                </div>
                <div class="col-sm-8">
                    <div class="form-group">
                        <?= lang('paying_by', 'paid_by_1'); ?>
                        <select name="paid_by" id="paid_by_1" class="form-control paid_by" data="" required="required">
                            <?= $this->bpas->paid_opts(); ?>
                        </select>
                    </div>
                </div>
            </div>
            
            <?php echo form_hidden($csrf); ?>
            <?php echo form_hidden(['id' => $user->id]); ?>

        </div>
        <div class="modal-footer">
            <?php echo form_submit('activate', lang('activate'), 'class="btn btn-primary"'); ?>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>
<?= $modal_js ?>

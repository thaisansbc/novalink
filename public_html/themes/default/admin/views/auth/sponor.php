<?php defined('BASEPATH') or exit('No direct script access allowed'); 
?>
<style>
    #chart-container {
        height: 300px;
        width: 100%;
        border: 1px dashed #aaa;
        overflow: auto;
    }

</style>
<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-sitemap"></i> <?= lang('sponsor'); ?></h2>
    </div>
    <div class="box-content">
        <?php $attrib = ['data-toggle' => 'validator', 'role' => 'form'];
                echo admin_form_open_multipart('auth/sponsor', $attrib);
                ?>
        <?php 
        if($sponsors){
        ?>
        <div class="col-md-4">
            <div class="form-group">
                <?= lang('sponsor', 'sponsor'); ?>
                <?php
                $opt_sp [''] = lang('selected');
                foreach ($sponsors as $sponsor) {
                    $opt_sp[$sponsor->id] = $sponsor->last_name.' '.$sponsor->first_name;
                }
                echo form_dropdown('sponsor', $opt_sp,'', 'class="form-control tip" id="sponsor" required="required" style="width:100%;"');
                ?>
            </div>
        </div>
        <div class="form-group">
            <label for="sponsosssr">&nbsp;</label>
            <div class="controls">
                <?= form_submit('search', lang('search'), 'class="btn btn-primary"'); ?>
            </div>
        </div>
        <?php 
        }
        ?>
        <div class="clear"></div>
        <div class="row">
            <div class="col-md-3">
                &nbsp;
            </div>
            <div class="col-md-6">
                <div id="chart-container">
                    <div style="">
                        <?php 
                        
                        $mainsponsor  = $this->auth_model->getSponsorByID($sponsor_id);
                        if($mainsponsor){
                            echo $mainsponsor->last_name.' '.$mainsponsor->first_name;
                        }
                        ?>
                    </div>
                    <?php 
                    $subs     = $this->auth_model->getSponsor($sponsor_id);
                    if(!empty($sponsor_id)){
                        $margin = 15;
                        if(!empty($subs)){
                            foreach($subs as $sub){
                            ?>
                            <div style="width: 300px;margin-bottom: 15px;margin-left:<?= $margin;?>px ;">
                                <div style="width:20px;height: 20px;border-left: 1px solid #000;border-bottom: 1px solid #000;float: left;">&nbsp;</div>
                                <div style="width: 200px;float: left;"><?= $sub->last_name.' '.$sub->first_name;?></div>
                                <div class="clear"></div>
                                    
                            </div>
                            <?php
                                $margin += $margin;
                            }
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="col-md-3">
                &nbsp;
            </div>
        </div>
        

        <?= form_close(); ?>
    </div>
</div>

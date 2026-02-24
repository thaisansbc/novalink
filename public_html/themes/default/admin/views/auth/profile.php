<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php $sp = ['0' => lang('no'), '1' => lang('yes')];
// $ids = array_column($submembers, 'id');
// $salemans_id = json_encode($ids);

?>

<div class="row">
    <div class="col-sm-2">
        <div class="row">
            <div class="col-sm-12 text-center">
                <div style="max-width:200px; margin: 0 auto;">
                    <?=
                        $user->avatar ? '<img alt="" src="' . base_url() . 'assets/uploads/avatars/thumbs/' . $user->avatar . '" class="avatar">' :
                            '<img alt="" src="' . base_url() . 'assets/images/' . $user->gender . '.png" class="avatar">';
                    ?>
                </div>
                <h4><?= lang('login_email'); ?></h4>
                <p><i class="fa fa-envelope"></i> <?= $user->email; ?></p>
            </div>
        </div>
    </div>
    <div class="col-sm-10">
        <ul id="myTab" class="nav nav-tabs">
            <li class=""><a href="#profile" class="tab-grey"><?= lang('profile') ?></a></li>
            <li class=""><a href="#edit" class="tab-grey"><?= lang('edit') ?></a></li>
            <li class=""><a href="#cpassword" class="tab-grey"><?= lang('change_password') ?></a></li>
            <li class=""><a href="#avatar" class="tab-grey"><?= lang('avatar') ?></a></li>
            <li class=""><a href="#signature" class="tab-grey"><?= lang('signature') ?></a></li>
        </ul>
        <div class="tab-content">
            <div id="profile" class="tab-pane fade in">
                <div class="box">
                    <div class="box-content">
                        <div class="row">
                            <div class="col-lg-12">
                                <table width="100%" class="table table-bordered table-hover table-striped">
                                    <tr>
                                        <td width="30%"><strong><?php echo lang('full_name'); ?></strong></td>
                                        <td colspan="2"><?php echo $user->first_name.' '.$user->last_name; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong><?php echo lang('ID'); ?></strong></td>
                                        <td colspan="2"><?php echo $user->username; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong><?php echo lang('phone'); ?></strong></td>
                                        <td colspan="2"><?= $user->phone ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong><?= lang('gender'); ?></strong></td>
                                        <td colspan="2"><?php echo $user->gender; ?></td>
                                    </tr>
                                    <?php 
                                    if($user->email){
                                    ?>
                                    <tr>
                                        <td><strong><?= lang('email'); ?></strong></td>
                                        <td colspan="2"><?php echo $user->email; ?></td>
                                    </tr>
                                    <?php
                                    }
                                    ?>
                                    <?php 
                                    $sponsor_bonus = 0;
                                    $sponsor_bonus = $bonus->total_bonus;

                                    //------------------ 
                                    $qualification_bonus = 0;
                                    if($qual_bonus->left_node && $qual_bonus->right_node && $PV >= 50){
                                        $qualification_bonus = 50;
                                    }
                                    $cycle_bonus =0;
                                    $left_bv = $getcycle_bonus[0]->side === 'left' ? $getcycle_bonus[0]->total_bv : $getcycle_bonus[1]->total_bv;
                                    $right_bv = $getcycle_bonus[0]->side === 'right' ? $getcycle_bonus[0]->total_bv : $getcycle_bonus[1]->total_bv;

                                    if($left_bv >= 500 && $left_bv >= 500){
                                        $cycle_bonus = 50;
                                    }

                                    ?>
                                    <tr>
                                        <td><strong><?= lang('sponsor_bonus'); ?></strong></td>
                                        <td colspan="2">$<?= $sponsor_bonus; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong><?= lang('qualification_bonus'); ?></strong></td>
                                        <td colspan="2">$<?= $qualification_bonus ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong><?= lang('cycle_bonus'); ?></strong></td>
                                        <td colspan="2">$<?= $cycle_bonus ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong><?= lang('total_bonus'); ?></strong></td>
                                        <td colspan="2">$<?= $this->bpas->formatMoney($sponsor_bonus + $qualification_bonus+$cycle_bonus);?></td>
                                    </tr>
                                    <tr>
                                        <td><strong><?= lang('status'); ?></strong></td>
                                        <td colspan="2"><?= ($user->active == 1) ? lang('active'):lang('inactive');?></td>
                                    </tr>
                                    <tr>
                                        <td><strong><?= lang('monthly_pv'); ?></strong></td>
                                       <td colspan="2">$<?= $this->bpas->formatMoney($PV); ?></td>
                                    </tr>
                                    
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div id="edit" class="tab-pane fade">
                <div class="box">
                    <div class="box-header">
                        <h2 class="blue"><i class="fa-fw fa fa-edit nb"></i><?= lang('edit_profile'); ?></h2>
                    </div>
                    <div class="box-content">
                        <div class="row">
                            <div class="col-lg-12">
                                <?php $attrib = ['class' => 'form-horizontal', 'data-toggle' => 'validator', 'role' => 'form'];
                                echo admin_form_open_multipart('auth/edit_user/' . $user->id, $attrib);
                                ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <?php echo lang('first_name', 'first_name'); ?>
                                                <div class="controls">
                                                    <?php echo form_input('first_name', $user->first_name, 'class="form-control" id="first_name" required="required"'); ?>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <?php echo lang('last_name', 'last_name'); ?>
                                                <div class="controls">
                                                    <?php echo form_input('last_name', $user->last_name, 'class="form-control" id="last_name" required="required"'); ?>
                                                </div>
                                            </div>
                                            <?php if (!$this->ion_auth->in_group('customer', $id) && !$this->ion_auth->in_group('supplier', $id)) { ?>
                                                <div class="form-group">
                                                    <?php echo lang('company', 'company'); ?>
                                                    <div class="controls">
                                                        <?php echo form_input('company', $user->company, 'class="form-control" id="company" required="required"'); ?>
                                                    </div>
                                                </div>
                                            <?php
                                            } else {
                                                echo form_hidden('company', $user->company);
                                            } ?>
                                            <div class="form-group">

                                                <?php echo lang('phone', 'phone'); ?>
                                                <div class="controls">
                                                    <input type="tel" name="phone" class="form-control" id="phone" value="<?= $user->phone ?>" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <?= lang('gender', 'gender'); ?>
                                                <div class="controls"> <?php
                                                                        $ge[''] = ['male' => lang('male'), 'female' => lang('female')];
                                                                        echo form_dropdown('gender', $ge, (isset($_POST['gender']) ? $_POST['gender'] : $user->gender), 'class="tip form-control" id="gender" required="required"');
                                                                        ?>
                                                </div>
                                            </div>
                                            <?php if (($Owner || $Admin || $Store) && $id != $this->session->userdata('user_id')) { ?>
                                                <div class="form-group">
                                                    <?= lang('award_points', 'award_points'); ?>
                                                    <?= form_input('award_points', set_value('award_points', $user->award_points), 'class="form-control tip" id="award_points"'); ?>
                                                </div>
                                            <?php } ?>
                                            <div class="form-group">
                                                <?= lang('status', 'status'); ?>
                                                <?php
                                                $opt = [1 => lang('active'), 0 => lang('inactive')];
                                                echo form_dropdown('status', $opt, (isset($_POST['status']) ? $_POST['status'] : $user->active), 'id="status" required="required" class="form-control input-tip select" style="width:100%;"'); ?>
                                            </div>
                                            <?php if (($Owner || $Store) && $id != $this->session->userdata('user_id')) { ?>
                                                <div class="form-group">
                                                    <?php echo lang('username', 'username'); ?>
                                                    <input type="text" name="username" class="form-control" id="username" value="<?= $user->username ?>" required="required" />
                                                </div>
                                                <div class="form-group">
                                                    <?php echo lang('email', 'email'); ?>
                                                    <input type="email" name="email" class="form-control" id="email" value="<?= $user->email ?>" />
                                                </div>
                                                <div class="row">
                                                    <div class="panel panel-warning">
                                                        <div class="panel-heading"><?= lang('if_you_need_to_rest_password_for_user') ?></div>
                                                        <div class="panel-body" style="padding: 5px;">
                                                            <div class="col-md-12">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <?php echo lang('password', 'password'); ?>
                                                                        <?php echo form_input($password); ?>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <?php echo lang('confirm_password', 'password_confirm'); ?>
                                                                        <?php echo form_input($password_confirm); ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                        <div class="col-md-6 col-md-offset-1">
                                            <?php if (($Owner || $Store) && $id != $this->session->userdata('user_id')) { ?>
                                                <div class="row">
                                                    <div class="panel panel-warning">
                                                        <div class="panel-heading"><?= lang('user_options') ?></div>
                                                        <div class="panel-body" style="padding: 5px;">
                                                            <div class="col-md-12">
                                                                <div class="col-md-12">
                                                                    <?php if (!$this->ion_auth->in_group('customer', $id) && !$this->ion_auth->in_group('supplier', $id)) { ?>
                                                                        <div class="form-group">
                                                                            <?= lang('group', 'group'); ?>
                                                                            <?php
                                                                            $gp[''] = '';
                                                                            foreach ($groups as $group) {
                                                                                if ($group['name'] != 'developer' && $group['name'] != 'customer' && $group['name'] != 'supplier') {
                                                                                    $gp[$group['id']] = lang($group['name']);
                                                                                }
                                                                            }
                                                                            echo form_dropdown('group', $gp, (isset($_POST['group']) ? $_POST['group'] : $user->group_id), 'id="group" data-placeholder="' . $this->lang->line('select') . ' ' . $this->lang->line('group') . '" required="required" class="form-control input-tip select" style="width:100%;"'); ?>
                                                                        </div>
                                                                         <div class="form-group hide">
                                                                            <?php echo lang('commission' . " (%)", 'commission'); ?>
                                                                            <div class="controls">
                                                                                <?php echo form_input('commission', $user->commission, 'class="form-control" id="commission"'); ?>
                                                                            </div>
                                                                        </div>
                                                                  
                                                                        <div class="form-group">
                                                                        <?= lang('zone', 'zone'); ?>
                                                                            <?php
                                                                            $m_zones = explode(',', $user->multi_zone);
                                                                            if ($zones) {
                                                                                foreach ($zones as $zone) {
                                                                                    $zns[$zone->p_id] = $zone->p_name && $zone->p_name != '-' ? $zone->p_name : $zone->p_name;
                                                                                    if($zone->c_id != null){
                                                                                        $child_zones_id = explode("___", $zone->c_id);
                                                                                        $child_zones_name = explode("___", $zone->c_name);
                                                                                        foreach ($child_zones_id as $key => $value) {
                                                                                            $zns[$value] = "&emsp;" . $child_zones_name[$key];
                                                                                        }
                                                                                    }
                                                                                }
                                                                            }
                                                                            // foreach ($zones as $zone) {
                                                                            //     $zns[$zone->id] = $zone->zone_name && $zone->zone_name != '-' ? $zone->zone_name : $zone->zone_name;
                                                                            // }
                                                                            echo form_dropdown('multi_zone[]', $zns, (isset($_POST['multi_zone']) ? $_POST['multi_zone'] : $m_zones), 'id="multi_zone" class="form-control select" data-placeholder="' . lang('select') . ' ' . lang('zone') . '" style="width:100%;" multiple="multiple"');
                                                                            ?>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <?= lang('save_point', 'save_point'); ?>
                                                                            <?php echo form_dropdown('save_point', $sp, (isset($_POST['save_point']) ? $_POST['save_point'] : $user->save_point), 'class="form-control input-tip select" id="save_point" style="width:100%;"'); ?> 
                                                                        </div>
                                                                        <div class="clearfix"></div>
                                                                        <div class="no">
                                                                            <?php if (!empty($billers) && count($billers) > 1) { ?>
                                                                                <?php if (!$this->Settings->multi_biller) { ?>
                                                                                <div class="form-group">
                                                                                    <?= lang('biller', 'biller'); ?>
                                                                                    <?php
                                                                                    $bl[''] = lang('select') . ' ' . lang('biller');
                                                                                    foreach ($billers as $biller) {
                                                                                        $bl[$biller->id] = $biller->company && $biller->company != '-' ? $biller->company : $biller->name;
                                                                                    }
                                                                                    echo form_dropdown('biller', $bl, (isset($_POST['biller']) ? $_POST['biller'] : $user->biller_id), 'id="biller" data-placeholder="' . $this->lang->line('select') . ' ' . $this->lang->line('biller') . '" class="form-control select" style="width:100%;"'); ?>
                                                                                </div>
                                                                                <?php } else { ?>
                                                                                <div class="form-group">
                                                                                    <?= lang('multi_Biller', 'multi_Biller'); ?>
                                                                                    <?php
                                                                                    $mbiller_id = explode(',', $data->multi_biller);
                                                                                    foreach ($billers as $biller) {
                                                                                        $bls[$biller->id] = $biller->company && $biller->company != '-' ? $biller->company : $biller->name;
                                                                                    }
                                                                                    echo form_dropdown('multi_biller[]', $bls, ( isset($_POST['multi_biller']) ? $_POST['multi_biller'] : $mbiller_id), 'id="multi_biller" data-placeholder="' . lang('select') . ' ' . lang('biller') . '" class="form-control select" style="width:100%;" multiple="multiple"');
                                                                                    ?>
                                                                                </div>
                                                                                <?php } ?>
                                                                            <?php } else {
                                                                                $biller_input = array(
                                                                                    'type'  => 'hidden',
                                                                                    'name'  => ($this->Settings->multi_biller ? 'multi_biller[]' : 'biller'),
                                                                                    'id'    => 'slbiller',
                                                                                    'value' => $billers[0]->id,
                                                                                );
                                                                                echo form_input($biller_input);
                                                                            } ?>
                                                                            <?php if (!empty($warehouses) && count($warehouses) > 1) { ?>
                                                                            <div class="form-group">
                                                                                <?= lang('warehouse', 'warehouse'); ?>
                                                                                <?php
                                                                                if (!$this->Settings->multi_warehouse) {
                                                                                    $wh[''] = lang('select') . ' ' . lang('warehouse');
                                                                                    $warehouse_id = $user->warehouse_id;
                                                                                    foreach ($warehouses as $warehouse) {
                                                                                        $wh[$warehouse->id] = $warehouse->name;
                                                                                    }
                                                                                    echo form_dropdown('warehouse', $wh, (isset($_POST['warehouse']) ? $_POST['warehouse'] : $warehouse_id), 'id="warehouse" class="form-control select" data-placeholder="' . $this->lang->line('select') . ' ' . $this->lang->line('warehouse') . '" style="width:100%;" ');
                                                                                } else {
                                                                                    $warehouse_id = explode(',', $user->warehouse_id);
                                                                                    foreach ($warehouses as $warehouse) {
                                                                                        $wh[$warehouse->id] = $warehouse->name;
                                                                                    }
                                                                                    echo form_dropdown('warehouse[]', $wh, (isset($_POST['warehouse']) ? $_POST['warehouse'] : $warehouse_id), 'id="warehouse" class="form-control select" multiple="multiple" data-placeholder="' . $this->lang->line('select') . ' ' . $this->lang->line('warehouse') . '" style="width:100%;" ');
                                                                                } ?>
                                                                            </div>
                                                                            <?php } else {
                                                                                $warehouse_input = array(
                                                                                    'type'  => 'hidden',
                                                                                    'name'  => ($this->Settings->multi_warehouse ? 'warehouse[]' : 'warehouse'),
                                                                                    'id'    => 'warehouse',
                                                                                    'value' => $warehouses[0]->id,
                                                                                );
                                                                                echo form_input($warehouse_input);
                                                                            } ?>
                                                                            <div class="form-group">
                                                                                <?= lang('view_right', 'view_right'); ?>
                                                                                <?php
                                                                                $vropts = [1 => lang('all_records'), 0 => lang('own_records')];
                                                                                echo form_dropdown('view_right', $vropts, (isset($_POST['view_right']) ? $_POST['view_right'] : $user->view_right), 'id="view_right" class="form-control select" style="width:100%;"'); ?>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <?= lang('edit_right', 'edit_right'); ?>
                                                                                <?php
                                                                                $opts = [1 => lang('yes'), 0 => lang('no')];
                                                                                echo form_dropdown('edit_right', $opts, (isset($_POST['edit_right']) ? $_POST['edit_right'] : $user->edit_right), 'id="edit_right" class="form-control select" style="width:100%;"'); ?>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <?= lang('allow_discount', 'allow_discount'); ?>
                                                                                <?= form_dropdown('allow_discount', $opts, (isset($_POST['allow_discount']) ? $_POST['allow_discount'] : $user->allow_discount), 'id="allow_discount" class="form-control select" style="width:100%;"'); ?>
                                                                            </div>
                                                                            
                                                                           <?php } ?>


                                                                           
                                                                            <div class="form-group">
                                                                                    <?= lang('node', 'node'); ?>
                                                                                    <?php
                                                                                    $node = ['main' => lang('main'),'sub' => lang('sub_node'),'' => 'please Select node'];
                                                                                    echo form_dropdown('node', $node, (isset($_POST['node']) ? $_POST['node'] : $user->node), 'id="node" class="form-control select" style="width:100%;"');
                                                                                    ?>
                                                                            </div>




                                                                            <div class="main-group">
                                                                                <div class="form-group">
                                                                                        <?= lang('main', 'main'); ?>
                                                                                            <?php
                                                                                             
                                                                                            echo form_input('main', (isset($_POST['main']) ? $_POST['main'] : ''), 'id="main" data-placeholder="' . lang('select') . ' ' . lang('main') . '" required="required" class="form-control input-tip" style="width:100%;"');
                                                                                        ?>
                                                                                </div>
                                                                            </div>


                                                                            
                              






                                                                        
                                                                        </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <?php echo form_hidden('id', $id); ?>
                                            <?php echo form_hidden($csrf); ?>
                                        </div>
                                    </div>
                                </div>
                                <p><?php echo form_submit('update', lang('update'), 'class="btn btn-primary"'); ?></p>
                                <?php echo form_close(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="cpassword" class="tab-pane fade">
                <div class="box">
                    <div class="box-header">
                        <h2 class="blue"><i class="fa-fw fa fa-key nb"></i><?= lang('change_password'); ?></h2>
                    </div>
                    <div class="box-content">
                        <div class="row">
                            <div class="col-lg-12">
                                <?php echo admin_form_open('auth/change_password', 'id="change-password-form"'); ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <?php echo lang('old_password', 'curr_password'); ?> <br />
                                                <?php echo form_password('old_password', '', 'class="form-control" id="curr_password" required="required"'); ?>
                                            </div>
                                            <div class="form-group">
                                                <label for="new_password"><?php echo sprintf(lang('new_password'), $min_password_length); ?></label>
                                                <br />
                                                <?php echo form_password('new_password', '', 'class="form-control" id="new_password" required="required" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" data-bv-regexp-message="' . lang('pasword_hint') . '"'); ?>
                                                <span class="help-block"><?= lang('pasword_hint') ?></span>
                                            </div>
                                            <div class="form-group">
                                                <?php echo lang('confirm_password', 'new_password_confirm'); ?> <br />
                                                <?php echo form_password('new_password_confirm', '', 'class="form-control" id="new_password_confirm" required="required" data-bv-identical="true" data-bv-identical-field="new_password" data-bv-identical-message="' . lang('pw_not_same') . '"'); ?>
                                            </div>
                                            <?php echo form_input($user_id); ?>
                                            <?php echo form_hidden('id', $id); ?>
                                            <?php echo form_hidden($csrf); ?>
                                            <p><?php echo form_submit('change_password', lang('change_password'), 'class="btn btn-primary"'); ?></p>
                                        </div>
                                    </div>
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<div id="avatar" class="tab-pane fade">
                <div class="box">
                    <div class="box-header">
                        <h2 class="blue"><i class="fa-fw fa fa-file-picture-o nb"></i><?= lang('change_avatar'); ?></h2>
                    </div>
                    <div class="box-content">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="col-md-5">
                                    <div style="position: relative;">
                                        <?php if ($user->avatar) { ?>
                                            <img alt="" src="<?= base_url() ?>assets/uploads/avatars/<?= $user->avatar ?>" class="profile-image img-thumbnail">
                                            <a href="#" class="btn btn-danger btn-xs po" style="position: absolute; top: 0;" title="<?= lang('delete_avatar') ?>" data-content="<p><?= lang('r_u_sure') ?></p><a class='btn btn-block btn-danger po-delete' href='<?= admin_url('auth/delete_avatar/' . $id . '/' . $user->avatar) ?>'> <?= lang('i_m_sure') ?></a> <button class='btn btn-block po-close'> <?= lang('no') ?></button>" data-html="true" rel="popover"><i class="fa fa-trash-o"></i></a><br>
                                            <br>
                                        <?php } ?>
                                    </div>
                                    <?php echo admin_form_open_multipart('auth/update_avatar'); ?>
                                    <div class="form-group">
                                        <?= lang('change_avatar', 'change_avatar'); ?>
                                        <input type="file" data-browse-label="<?= lang('browse'); ?>" name="avatar" id="product_image" required="required" data-show-upload="false" data-show-preview="true" accept="image/*" class="form-control file" />
                                    </div>
                                    <div class="form-group">
                                        <?php echo form_hidden('id', $id); ?>
                                        <?php echo form_hidden($csrf); ?>
                                        <?php echo form_submit('update_avatar', lang('update_avatar'), 'class="btn btn-primary"'); ?>
                                        <?php echo form_close(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
</div>
            <div id="signature" class="tab-pane fade">
                <div class="box">
                    <div class="box-header">
                        <h2 class="blue"><i class="fa-fw fa fa-file-picture-o nb"></i><?= lang('signature'); ?></h2>
                    </div>
                    <div class="box-content">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="col-md-5">
                                    <div style="position: relative;">
                                        <?php if ($user->signature) { ?>
                                            <img alt="" src="<?= base_url() ?>assets/uploads/avatars/<?= $user->signature ?>" class="profile-image img-thumbnail">
                                            <a href="#" class="btn btn-danger btn-xs po" style="position: absolute; top: 0;" title="<?= lang('delete_avatar') ?>" data-content="<p><?= lang('r_u_sure') ?></p><a class='btn btn-block btn-danger po-delete' href='<?= admin_url('auth/delete_avatar/' . $id . '/' . $user->signature) ?>'> <?= lang('i_m_sure') ?></a> <button class='btn btn-block po-close'> <?= lang('no') ?></button>" data-html="true" rel="popover"><i class="fa fa-trash-o"></i></a><br>
                                            <br>
                                        <?php } ?>
                                    </div>
                                    <?php echo admin_form_open_multipart('auth/signature'); ?>
                                    <div class="form-group">
                                        <?= lang('signature', 'signature'); ?>
                                        <input type="file" data-browse-label="<?= lang('browse'); ?>" name="signature" id="signature" required="required" data-show-upload="false" data-show-preview="true" accept="image/*" class="form-control file" />
                                    </div>
                                    <div class="form-group">
                                        <?php echo form_hidden('id', $id); ?>
                                        <?php echo form_hidden($csrf); ?>
                                        <?php echo form_submit('signature', lang('update_signature'), 'class="btn btn-primary"'); ?>
                                        <?php echo form_close(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>










<div class="tab-pane">
    <div class="box">
        <div class="box-content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="col-md-6">

                        <?= admin_form_open_multipart('auth/profile/'.$id); ?>

                        <!-- Start date -->
                        <div class="form-group">
                            <label>Start Date</label>
                        <input type="date" name="start_date" class="form-control" required value="<?= date('Y-m-01') ?>">

                        </div>

                        <!-- Week buttons -->
                        <div class="form-group">
                            <label>Sales Per Week</label><br>

                            <button type="submit" name="week" value="1" class="btn btn-primary">
                                1 Week
                            </button>

                            <button type="submit" name="week" value="2" class="btn btn-info">
                                2 Week
                            </button>

                            <button type="submit" name="week" value="3" class="btn btn-warning">
                                3 Week
                            </button>

                            <button type="submit" name="week" value="4" class="btn btn-success">
                                4 Week
                            </button>
                        </div>

                        <?= form_close(); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bv-compact {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        max-width: 100%;
        overflow-x: auto;
        padding: 10px;
        background: #f5f7fb;
    }

    .tree-compact {
        position: relative;
        margin: 5px 0;
    }

    .node-compact {
        background: white;
        border-radius: 6px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        margin-bottom: 10px;
        border: 1px solid #e9ecef;
        font-size: 12px;
    }

    .node-header-compact {
        background: linear-gradient(135deg, #4a5568 0%, #2d3748 100%);
        color: white;
        padding: 4px 8px;
        font-weight: 500;
        font-size: 11px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-radius: 6px 6px 0 0;
    }

    .node-label-compact {
        background: rgba(255,255,255,0.15);
        padding: 2px 6px;
        border-radius: 10px;
        font-size: 9px;
    }

    .split-compact {
        display: flex;
        padding: 6px;
        gap: 6px;
    }

    .side-compact {
        flex: 1;
        background: #f8fafc;
        border-radius: 4px;
        padding: 6px;
    }

    .side-left {
        border-left: 2px solid #4299e1;
    }

    .side-right {
        border-left: 2px solid #fc8181;
    }

    .side-header-compact {
        font-size: 10px;
        font-weight: 600;
        margin-bottom: 4px;
        padding-bottom: 2px;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .side-name-compact {
        color: #4a5568;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 80px;
    }

    .stats-compact {
        display: flex;
        gap: 3px;
    }

    .stat-compact {
        flex: 1;
        background: white;
        border-radius: 3px;
        padding: 3px;
        text-align: center;
        box-shadow: 0 1px 2px rgba(0,0,0,0.02);
    }

    .stat-label-compact {
        font-size: 7px;
        color: #718096;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .stat-value-compact {
        font-size: 11px;
        font-weight: 600;
        color: #2d3748;
        line-height: 1.2;
    }

    .badge-compact {
        display: inline-block;
        padding: 1px 3px;
        border-radius: 2px;
        font-size: 6px;
        font-weight: 600;
        text-transform: uppercase;
    }

    .badge-combo {
        background: #9f7aea;
        color: white;
    }

    .badge-standard {
        background: #4299e1;
        color: white;
    }

    .total-compact {
        background: #48bb78;
    }

    .total-compact .stat-value-compact {
        color: white;
    }

    .children-compact {
        display: flex;
        gap: 8px;
        margin-top: 5px;
        padding: 0 8px 5px 8px;
    }

    .child-compact {
        flex: 1;
        position: relative;
    }

    .child-compact::before {
        content: '';
        position: absolute;
        top: -5px;
        left: 50%;
        width: 1px;
        height: 5px;
        background: #cbd5e0;
    }

    .child-title-compact {
        font-size: 8px;
        color: #718096;
        text-align: center;
        margin-bottom: 2px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .branch-line-compact {
        display: flex;
        justify-content: center;
        gap: 20px;
        margin: 2px 0;
        font-size: 8px;
        color: #a0aec0;
    }

    .branch-line-compact span {
        position: relative;
    }

    .branch-line-compact span::before {
        content: '↓';
        position: absolute;
        top: -8px;
        left: 50%;
        transform: translateX(-50%);
        font-size: 8px;
    }

    @media (max-width: 480px) {
        .split-compact {
            flex-direction: column;
        }
        
        .children-compact {
            flex-direction: column;
        }
    }
</style>

<div class="bv-compact hide">
    <?php
    function renderTreeCompact($node, $label = 'ROOT', $level = 1) {
        if (!$node) return;
        
        $leftTotal = ($node['standard_left'] ?? 0) + ($node['combo_left'] ?? 0);
        $rightTotal = ($node['standard_right'] ?? 0) + ($node['combo_right'] ?? 0);
    ?>
    
    <div class="tree-compact" style="margin-left: <?= $level * 15 ?>px;">
        <div class="node-compact">
            <div class="node-header-compact">
                <span>
                    <?= str_repeat('•', $level + 1) ?> <?= $label ?>
                </span>
                <span class="node-label-compact">
                    Lv.<?= $level ?>
                </span>
            </div>
            
            <div class="split-compact">
                <!-- Left Side -->
                <div class="side-compact side-left">
                    <div class="side-header-compact">
                        <span>◀</span>
                        <span class="side-name-compact" title="<?= htmlspecialchars($node['left_name'] ?? 'LEFT') ?>">
                            <?= htmlspecialchars(substr($node['left_name'] ?? 'LEFT', 0, 12)) ?>
                        </span>
                    </div>
                    
                    <div class="stats-compact">
                        <div class="stat-compact">
                            <div class="stat-label-compact">
                                <span class="badge-compact badge-combo">C</span>
                            </div>
                            <div class="stat-value-compact"><?= $node['combo_left'] ?? 0 ?></div>
                        </div>
                        <div class="stat-compact">
                            <div class="stat-label-compact">
                                <span class="badge-compact badge-standard">S</span>
                            </div>
                            <div class="stat-value-compact"><?= $node['standard_left'] ?? 0 ?></div>
                        </div>
                        <div class="stat-compact total-compact">
                            <div class="stat-label-compact">TOT</div>
                            <div class="stat-value-compact"><?= $leftTotal ?></div>
                        </div>
                    </div>
                </div>
                
                <!-- Right Side -->
                <div class="side-compact side-right">
                    <div class="side-header-compact">
                        <span class="side-name-compact" title="<?= htmlspecialchars($node['right_name'] ?? 'RIGHT') ?>">
                            <?= htmlspecialchars(substr($node['right_name'] ?? 'RIGHT', 0, 12)) ?>
                        </span>
                        <span>▶</span>
                    </div>
                    
                    <div class="stats-compact">
                        <div class="stat-compact">
                            <div class="stat-label-compact">
                                <span class="badge-compact badge-combo">C</span>
                            </div>
                            <div class="stat-value-compact"><?= $node['combo_right'] ?? 0 ?></div>
                        </div>
                        <div class="stat-compact">
                            <div class="stat-label-compact">
                                <span class="badge-compact badge-standard">S</span>
                            </div>
                            <div class="stat-value-compact"><?= $node['standard_right'] ?? 0 ?></div>
                        </div>
                        <div class="stat-compact total-compact">
                            <div class="stat-label-compact">TOT</div>
                            <div class="stat-value-compact"><?= $rightTotal ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Children -->
        <?php if (!empty($node['left']) || !empty($node['right'])): ?>
            <div class="branch-line-compact">
                <span>L</span>
                <span>R</span>
            </div>
            
            <div class="children-compact">
                <div class="child-compact">
                    <?php if (!empty($node['left'])): ?>
                        <div class="child-title-compact">LEFT</div>
                        <?php renderTreeCompact($node['left'], $label . '→L', $level + 1); ?>
                    <?php endif; ?>
                </div>
                
                <div class="child-compact">
                    <?php if (!empty($node['right'])): ?>
                        <div class="child-title-compact">RIGHT</div>
                        <?php renderTreeCompact($node['right'], $label . '→R', $level + 1); ?>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
    
    <?php
    }
    
    renderTreeCompact($bv_tree);
    ?>
</div>
<div class="box hide">
    <div class="box-content">
        <div class="row">
            <div class="col-sm-12">
                <table id="PRData" class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                            <th colspan="5" style="text-align: center !important;">BV Status</th>
                        </tr>
                        <tr>
                            <th rowspan="2">Week</th>
                            <th colspan="2">In Week</th>
                            <th colspan="2">Balance</th>
                        </tr>
                        <tr>
                            <th>BV(Left)</th>
                            <th>BV(Right)</th>
                            <th>BV(Left)</th>
                            <th>BV(Right)</th>
                        </tr>
                    </thead>


                    

                <tbody>
                    <?php
                     $total_bvleft = 0;
                    $total_bvright = 0;
                    if (!empty($sales)) {

                      
                        $leftRows  = [];
                        $rightRows = [];

                        foreach ($sales as $sale) {
                            if ($sale->side === 'left') {
                                $leftRows[] = $sale;
                                $total_bvleft += $sale->total_bv;
                            } elseif ($sale->side === 'right') {
                                $rightRows[] = $sale;
                                $total_bvright += $sale->total_bv;
                            }
                        }
                        $maxRows = max(count($leftRows), count($rightRows));
                        for ($i = 0; $i < $maxRows; $i++) {
                            $leftValue  = isset($leftRows[$i])  ? $leftRows[$i]->total_bv  : '';
                            $rightValue = isset($rightRows[$i]) ? $rightRows[$i]->total_bv : '';
                            ?>
                            <tr>
                                <td></td>
                                <td><?= $leftValue ?></td>
                                <td><?= $rightValue ?></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                    </tbody>


                    <tfoot>
                        <th><?= lang('total');?></th>
                        <th><?= $total_bvleft;?></th>
                        <th><?= $total_bvright;?></th>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>



<div class="box ">
    <div class="box-content">
        <div class="row">
            <div class="col-sm-12">
                <table id="PRData" class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                            <th colspan="5" style="text-align: center !important;">BV Status</th>
                        </tr>
                        <tr>
                            <th rowspan="2">Week</th>
                            <th colspan="2">In Week</th>
                            <th colspan="2">Balance</th>
                        </tr>
                        <tr>
                            <th>BV(Left)</th>
                            <th>BV(Right)</th>
                            <th>BV(Left)</th>
                            <th>BV(Right)</th>
                        </tr>
                    </thead>


                    

                <!-- <tbody>
                    <?php
                     $total_bvleft = 0;
                    $total_bvright = 0;
                    if (!empty($sales)) {

                      
                        $leftRows  = [];
                        $rightRows = [];

                        foreach ($sales as $sale) {
                            if ($sale->side === 'left') {
                                $leftRows[] = $sale;
                                $total_bvleft += $sale->total_bv;
                            } elseif ($sale->side === 'right') {
                                $rightRows[] = $sale;
                                $total_bvright += $sale->total_bv;
                            }
                        }
                        $maxRows = max(count($leftRows), count($rightRows));
                        for ($i = 0; $i < $maxRows; $i++) {
                            $leftValue  = isset($leftRows[$i])  ? $leftRows[$i]->total_bv  : '';
                            $rightValue = isset($rightRows[$i]) ? $rightRows[$i]->total_bv : '';
                            ?>
                            <tr>
                                <td></td>
                                <td><?= $leftValue ?></td>
                                <td><?= $rightValue ?></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                    </tbody> -->





                  <!-- <tbody>
                    <?php
                    $total_bvleft  = 0;
                    $total_bvright = 0;

                    $groupedSales = [];

                    if (!empty($sales)) {

                        foreach ($sales as $sale) {

                            $user_id = $sale->saleman_by;

                            // Initialize if not exists
                            if (!isset($groupedSales[$user_id])) {
                                $groupedSales[$user_id] = [
                                    'left'  => 0,
                                    'right' => 0,
                                ];
                            }

                            // Sum by side
                            if ($sale->side === 'left') {
                                $groupedSales[$user_id]['left'] += $sale->total_bv;
                                $total_bvleft += $sale->total_bv;
                            }

                            if ($sale->side === 'right') {
                                $groupedSales[$user_id]['right'] += $sale->total_bv;
                                $total_bvright += $sale->total_bv;
                            }
                        }

                        // Display rows (1 row per user)
                        foreach ($groupedSales as $user_id => $bv) {
                            ?>
                            <tr>
                                <td><?= $user_id ?></td>
                                <td><?= $bv['left'] > 0 ? number_format($bv['left'], 2) : '' ?></td>
                                <td><?= $bv['right'] > 0 ? number_format($bv['right'], 2) : '' ?></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                    </tbody> -->




                    <?php

                    $total_week_left   = 0;
                    $total_week_right  = 0;
                    $total_all_left    = 0;
                    $total_all_right   = 0;

                    $groupedSales     = []; // weekly / filtered
                    $groupedAllSales  = []; // all sales
                    // PROCESS WEEKLY / FILTERED SALES
                    if (!empty($sales)) {
                        foreach ($sales as $sale) {

                            $user_id = $sale->saleman_by;

                            if (!isset($groupedSales[$user_id])) {
                                $groupedSales[$user_id] = [
                                    'left'  => 0,
                                    'right' => 0
                                ];
                            }
                            if ($sale->side === 'left') {
                                $groupedSales[$user_id]['left'] += $sale->total_bv;
                                $total_week_left += $sale->total_bv;
                            }

                            if ($sale->side === 'right') {
                                $groupedSales[$user_id]['right'] += $sale->total_bv;
                                $total_week_right += $sale->total_bv;
                            }
                        }
                    }
                            // var_dump($sales);exit();

                    // PROCESS ALL SALES
                    if (!empty($allsales)) {
                        foreach ($allsales as $sale) {

                            $user_id = $sale->saleman_by;

                            if (!isset($groupedAllSales[$user_id])) {
                                $groupedAllSales[$user_id] = [
                                    'left'  => 0,
                                    'right' => 0
                                ];
                            }

                            if ($sale->side === 'left') {
                                $groupedAllSales[$user_id]['left'] += $sale->total_bv;
                                $total_all_left += $sale->total_bv;
                            }

                            if ($sale->side === 'right') {
                                $groupedAllSales[$user_id]['right'] += $sale->total_bv;
                                $total_all_right += $sale->total_bv;
                            }
                        }
                    }
                    // MERGE USERS (from both arrays)
                    $allUsers = array_unique(array_merge(
                        array_keys($groupedSales),
                        array_keys($groupedAllSales)
                    ));
                    // DISPLAY TABLE ROWS
                    foreach ($allUsers as $user_id) {
                        $user = $this->site->getUserByID($user_id);
                        // var_dump($user_id);
                        $weekLeft  = $groupedSales[$user_id]['left']  ?? 0;
                        $weekRight = $groupedSales[$user_id]['right'] ?? 0;

                        $allLeft   = $groupedAllSales[$user_id]['left']  ?? 0;
                        $allRight  = $groupedAllSales[$user_id]['right'] ?? 0;
                        ?>
                        <tr>
                            <td><?= $user->username ?></td>
                            <td><?= $weekLeft  > 0 ? number_format($weekLeft, 2)  : 0 ?></td>
                            <td><?= $weekRight > 0 ? number_format($weekRight, 2) : 0 ?></td>
                            <td><?= $allLeft   > 0 ? number_format($allLeft, 2)   : 0 ?></td>
                            <td><?= $allRight  > 0 ? number_format($allRight, 2)  : 0 ?></td>
                        </tr>
                    <?php } ?>
                    <tfoot>
                    <tr style="font-weight:bold;">
                        <th><?= lang('total'); ?></th>
                        <th><?= number_format($total_week_left, 2); ?></th>
                        <th><?= number_format($total_week_right, 2); ?></th>
                        <th><?= number_format($total_all_left, 2); ?></th>
                        <th><?= number_format($total_all_right, 2); ?></th>
                    </tr>
                </tfoot>

                </table>
            </div>
        </div>
    </div>
</div>



    <script>
        $(document).ready(function() {

          
            $('#change-password-form').bootstrapValidator({
                message: 'Please enter/select a value',
                submitButtons: 'input[type="submit"]'
            });
        });
    </script>
        <?php if ($Owner && $id != $this->session->userdata('user_id')) { ?>
        <script type="text/javascript" charset="utf-8">
            $(document).ready(function() {

                $('#group').change(function(event) {
                    var group = $(this).val();
                    if (group == 1) {
                        $('.no').slideUp();
                    } else {
                        $('.no').slideDown();
                    }
                });
                var group = <?= $user->group_id ?>;
                if (group == 1) {
                    $('.no').slideUp();
                } else {
                    $('.no').slideDown();
                }

                if ($('#node').val() == 'main' || $('#node').val() == '') {
                    $('.main-group').slideUp();
                } else {
                    $('.main-group').slideDown();
                }


                $('#node').change(function(event) {
                    var node = $(this).val();
                    if (node == 'main' || node == '') {
                        $('.main-group').slideUp();
                    } else {
                        $('.main-group').slideDown();
                    }
                });

                // $('#main').select2('val', 22);

                //   $('#sltax2').change(function(e) {
                   
                //     $('#sltax2').val($(this).val());
                // });

                $('#main').select2({
                    minimumInputLength: 1,
                    ajax: {
                        url: site.base_url + 'auth/suggestions',
                        dataType: 'json',
                        quietMillis: 15,
                        data: function(term, page) {
                            return {
                                term: term,
                                limit: 10,
                                main:  <?= $user->main_node ? $user->id : null ?>,
                            };
                        },
                        results: function(data, page) {
                            if (data.results != null) {
                                console.log(data);
                                return { results: data.results };
                            } else {
                                return { results: [{ id: '', text: 'No Match Found' }] };
                            }
                        },
                    },
                });
            });
        </script>
    <?php } ?>
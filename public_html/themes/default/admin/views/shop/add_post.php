<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

    
    <div class="row">
        <?php $attrib = ['data-toggle' => 'validator', 'role' => 'form'];
        echo admin_form_open_multipart('shop_settings/add_post', $attrib);
        ?>
        <div class="col-lg-8">
            <div class="box">
                <div class="box-header">
                    <h2 class="blue"><i class="fa-fw fa fa-cog"></i><?= lang('add_post'); ?></h2>
                </div>
                <div class="box-content">
                    <div class="row">
                        <div class="col-lg-12">
                            <p class="introtext"><?= lang('enter_info'); ?></p>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <?= lang('title', 'title'); ?>
                                            <?= form_input('title', set_value('title'), 'class="form-control gen_slugs" id="title" pattern=".{3,60}" required="" data-fv-notempty-message="' . lang('title_required') . '"'); ?>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <?= lang('slug', 'slug'); ?>
                                            <?= form_input('slug', set_value('slug'), 'class="form-control" id="slug" required="" data-fv-notempty-message="' . lang('slug_required') . '"'); ?>
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <?= lang('description', 'description'); ?>
                                            <?= form_input('description', set_value('description'), 'class="form-control" id="description" required="" data-fv-notempty-message="' . lang('description_required') . '"'); ?>
                                        </div>
                                        <div class="form-group">
                                            <?= lang('body', 'body'); ?>
                                            <?= form_textarea('body', set_value('body'), 'class="form-control body" id="body" required="" data-fv-notempty-message="' . lang('body_required') . '"'); ?>
                                        </div>
                                        
                                    </div>

                                </div>
                            </div>

                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="box">
                <div class="box-content">
                    <div class="row">
                        <div class="col-md-12 text-right">
                            <div class="form-group">
                                <?php echo form_submit('add_post', lang('add_post'), 'class="btn btn-primary"'); ?>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label class="checkbox" for="active">
                                <input type="checkbox" name="active" value="1" id="active" checked="checked"/>
                                <?= lang('active') ?>
                            </label>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <?= lang('categories', 'categories'); ?>
                                <?php 
                                $get_fields = $this->site->getcustomfield('post_categories');
                                $field ['']=lang('select');
                                if (!empty($get_fields)) {
                                    foreach ($get_fields as $field_id) {
                                        $field[$field_id->id] = $field_id->name;
                                    }
                                }
                                echo form_dropdown('post_category',$field, set_value('post_category'), 'class="form-control select" required'); ?>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group all">
                                <?= lang('product_image', 'product_image') ?>
                                <input id="product_image" type="file" data-browse-label="<?= lang('browse'); ?>" name="product_image" data-show-upload="false" data-show-preview="true" accept="image/*" class="form-control file">
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>

<script>
    $(document).ready(function() {
        $('.gen_slugs').change(function(e) {
            getSlug($(this).val(), 'post');
        });
    });
</script>
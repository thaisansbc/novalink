<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

    
    <div class="row">
       <?php $attrib = ['data-toggle' => 'validator', 'role' => 'form'];
        echo admin_form_open_multipart('shop_settings/edit_post/' . $page->id, $attrib);
        ?>
        <div class="col-lg-8">
            <div class="box">
                <div class="box-header">
                    <h2 class="blue"><i class="fa-fw fa fa-cog"></i><?= lang('edit_post'); ?></h2>
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
                                            <?= form_input('title', set_value('title', $page->title), 'class="form-control gen_slugs" id="title" pattern=".{3,60}" required="" data-fv-notempty-message="' . lang('title_required') . '"'); ?>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <?= lang('slug', 'slug'); ?>
                                            <?= form_input('slug', set_value('slug', $page->slug), 'class="form-control" id="slug" required="" data-fv-notempty-message="' . lang('slug_required') . '"'); ?>
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <?= lang('description', 'description'); ?>
                                            <?= form_input('description', set_value('description', $page->description), 'class="form-control" id="description" required="" data-fv-notempty-message="' . lang('description_required') . '"'); ?>
                                        </div>
                                        <div class="form-group">
                                            <?= lang('body', 'body'); ?>
                                            <?= form_textarea('body', $page->detail, 'class="form-control body" id="body" required="" data-fv-notempty-message="' . lang('body_required') . '"'); ?>
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
                                <?php echo form_submit('update_post', lang('update_post'), 'class="btn btn-primary"'); ?>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label class="checkbox" for="active">
                            <input type="checkbox" name="active" value="1" id="active" <?= $page->active ? 'checked="checked"' : ''; ?>/>
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
                                echo form_dropdown('post_category',$field, set_value('post_category', $page->category_id), 'class="form-control select" required'); ?>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group all">
                                <?= lang('product_image', 'product_image') ?>

                                <input id="product_image" type="file" data-browse-label="<?= lang('browse'); ?>" name="product_image" data-show-upload="false" data-show-preview="true" accept="image/*" class="form-control file">

                                <div id="image-preview-container" style="margin-top: 20px;">
                                    <?php if(!empty($page->image)): ?>
                                        <div class="preview-wrapper">
                                            <img src="<?= base_url('assets/uploads/'.$page->image) ?>" 
                                                 class="img-thumbnail" 
                                                 style="max-width: 200px; max-height: 200px;">
                                            <div class="mt-2">
                                                <button type="button" id="<?= $page->id;?>" class="btn btn-danger btn-sm remove-image" 
                                                        data-image-name="<?= $page->image ?>">
                                                    <i class="fa fa-trash"></i> Remove Image
                                                </button>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
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
      // Remove existing uploaded image via AJAX
    $(document).on('click', '.remove-image', function() {
        var post_id = $(this).attr('id');
        if(confirm('Are you sure you want to remove this image?')) {
            $.ajax({
                url: '<?= admin_url("shop_settings/delete_feature_image/") ?>'+post_id,
                type: 'GET',
                data: {
                    post_id: post_id
                },
                success: function(response) {
                    if(response.success) {
                        $('#image-preview-container').empty();
                        $('input[name="existing_image"]').val('');
                        $('#product_image').val('');

                    }
                    window.location.reload();
                }
            });
        }
    });
</script>
<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-cog"></i><?= lang('edit_page'); ?></h2>
    </div>
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">

                <p class="introtext"><?= lang('update_info'); ?></p>

                <?php $attrib = ['data-toggle' => 'validator', 'role' => 'form'];
                echo admin_form_open('shop_settings/edit_page/' . $page->id, $attrib);
                ?>
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <div class="form-group">
                                <?= lang('title', 'title'); ?>
                                <?= form_input('title', set_value('title', $page->title), 'class="form-control gen_slugs" id="title" pattern=".{3,60}" required="" data-fv-notempty-message="' . lang('title_required') . '"'); ?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <?= lang('slug', 'slug'); ?>
                                <?= form_input('slug', set_value('slug', $page->slug), 'class="form-control" id="slug" required="" data-fv-notempty-message="' . lang('slug_required') . '"'); ?>
                            </div>
                        </div>                    
                        <div class="col-md-3">
                            <div class="form-group">
                                <?= lang('menu_order', 'order_no'); ?>
                                <?= form_input('order_no', set_value('order_no', $page->order_no), 'class="form-control" id="order_no" required=""'); ?>
                            </div>
                        </div>
                        <div class="clearfix"></div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <?= lang('description', 'description'); ?>
                                <?= form_input('description', set_value('description', $page->description), 'class="form-control" id="description" required="" data-fv-notempty-message="' . lang('description_required') . '"'); ?>
                            </div>
                            <div class="form-group">
                                <?= lang('body', 'body'); ?>
                                <?= form_textarea('body', $this->bpas->decode_html($page->body), 'class="form-control body" id="body" required="" data-fv-notempty-message="' . lang('body_required') . '"'); ?>
                            </div>

                            <label class="checkbox" for="active">
                            <input type="checkbox" name="active" value="1" id="active" <?= $page->active ? 'checked="checked"' : ''; ?>/>
                                <?= lang('active') ?>
                            </label>

                            <?php echo form_submit('edit_page', lang('edit_page'), 'class="btn btn-primary"'); ?>
                        </div>

                    </div>
                </div>

                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('.gen_slugs').change(function(e) {
            getSlug($(this).val(), 'post');
        });
    });
</script>
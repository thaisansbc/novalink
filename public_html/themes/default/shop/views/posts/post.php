<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<section class="page-contents">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">

                <div class="row">
                    <div class="col-sm-9 col-md-9">
                        <div class="panel panel-default margin-top-lg">
                            <div class="panel-heading text-bold">
                                <?= $page->title; ?>
                            </div>
                            <div class="panel-body">
                                <img src="<?= base_url('assets/uploads/'.$page->image) ?>">
                                <br><br>
                                <?php 
                                echo $this->bpas->decode_html($page->detail); ?>
                                <?php
                                if ($page->slug == $shop_settings->contact_link) {
                                    echo '<p><button type="button" class="btn btn-primary email-modal">Send us email</button></p>';
                                }
                                ?>
                            </div>
                            <div id="cart-helper" class="panel panel-footer margin-bottom-no hide">
                                <?= lang('updated_at') . ': ' . $this->bpas->hrld($page->updated_at); ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-3 col-md-3">
                        <?php include 'post_sidebar.php'; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

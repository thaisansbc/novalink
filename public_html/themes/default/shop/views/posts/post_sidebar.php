<div id="sticky-con">
    <?php
    if ($sidebar_posts) {
        ?>
        <h4 class="margin-top-md title text-bold">
            <span><?= lang('featured'); ?></span>
            <div class="pull-right">
                <div class="controls pull-right hidden-xs">
                    <a class="left fa fa-chevron-left btn btn-xs btn-default" href="#carousel-example"
                    data-slide="prev"></a>
                    <a class="right fa fa-chevron-right btn btn-xs btn-default" href="#carousel-example"
                    data-slide="next"></a>
                </div>
            </div>
        </h4>

        <div id="carousel-example" class="carousel slide" data-ride="carousel">
            <!-- Wrapper for slides -->
            <div class="carousel-inner">
                <?php
                $r = 0;
                foreach (array_chunk($sidebar_posts, 2) as $posts) {
                ?>
                    <div class="item <?= empty($r) ? 'active' : ''; ?>">
                        <div class="featured-products">
                            <?php
                            foreach ($posts as $post) {
                                ?>
                                <div class="product" style="z-index: 1;">
                                    <div class="details" style="transition: all 100ms ease-out 0s;">
                                       
                                        <img src="<?= base_url('assets/uploads/' . $post->image); ?>" alt="">
                                      
                                        <div class="stats-container">
                                            
                                            <span class="product_name">
                                                <a href="<?= site_url('post/' . $post->slug); ?>"><?= $post->title; ?></a>
                                            </span>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>

                                <?php
                            } ?>
                        </div>
                    </div>
                    <?php
                    $r++;
        } ?>
            </div>
        </div>
        <?php
    }
    ?>
</div>

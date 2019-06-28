<?php //requête pour création slider client
$args = array(
    'post_type' => 'jpm_slider',
    'posts_per_page' => -1,
    'orderby' => 'menu_order',
    'order' => 'ASC'
);
$slider_query = new WP_Query($args);
if ($slider_query->have_posts()):
    ?>
    <section id="home-carousel" class="m-dw-30">
        <div class="container">
            <div class="bd-example">
                <div id="slider-01" class="carousel slide">
                    <!-- Indicator -->
                    <ol class="carousel-indicators">
                        <?php
                        while ($slider_query -> have_posts()) : $slider_query->the_post();
                            echo '<li data-target="#slider-01" data-slide-to="' . $slider_query -> current_post . '" 
                            class="' . ($slider_query -> current_post == 0 ? "active" : "") . ' "></li>';
                             endwhile; ?>
                    </ol>
                    <?php rewind_posts(); ?>
                    <!-- Wrapper for slide -->
                    <div class="carousel-inner">
                        <?php
                        while ($slider_query->have_posts()) : $slider_query->the_post();

                            if ($thumbnail_html = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'front-slider')) :
                                $thumbnail_src = $thumbnail_html['0'];
                                $alt_val = get_post_meta(get_post_thumbnail_id($post->ID), '_wp_attachment_image_alt');
                                $alt_val = $alt_val[0];
                                ?>
                                <div class="carousel-item <?php echo($slider_query -> current_post == 0 ? " active" : "") ?> ">
                                    <img src="<?php echo $thumbnail_src; ?>"
                                         class="d-block w-100" alt="<?php echo $alt_val; ?>">
                                    <div class="carousel-caption d-none d-md-block">
                                        <h5 data-animation = "animated bounceInDown" ><?php the_title(); ?> </h5>
                                        <p data-animation = "animated bounceInDown" >Nulla vitae elit libero, a pharetra augue mollis interdum.</p>
                                    </div>
                                </div>
                                <?php endif;
                        endwhile;
                        wp_reset_postdata(); ?>
                    </div>
                    <!-- Controls -->
                    <a class="carousel-control-prev" href="#slider-01" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#slider-01" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div><!-- /container -->
    </section>

<?php endif; ?>
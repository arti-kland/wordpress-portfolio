<?php
/*
 * Template Name: liste par style
 */

get_header(); ?>

<?php $jpm_term_list = get_terms(array('taxonomy' => 'genre_mus', 'hide_empty' => true));
if (count($jpm_term_list) > 0):
    foreach ($jpm_term_list as $the_term): ?>
        <section class="media-front">

            <?php $args_taxo_rupt = array(
                'post_type' => 'jpm_media',
                'posts_per_page' => -1,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'genre_mus',
                        'field' => 'slug',
                        'terms' => $the_term->slug
                    )
                )
            );
            $req_taxo_rupt = new WP_Query($args_taxo_rupt); ?>
            <?php
            if ($req_taxo_rupt->have_posts()): ?>
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <h1><?php echo $the_term->name; ?></h1>
                        </div>
                        <?php while ($req_taxo_rupt->have_posts()): ?>
                            <?php $req_taxo_rupt->the_post(); ?>

                            <article class="col-xs-12 col-sm-6 col-md-3">
                                <div class="card-img">
                                    <?php the_post_thumbnail('medium-large', array('class' => 'img-fluid')); ?>
                                    <div class="card-footer">
                                        <h1 class="h4 text-center"><?php the_title(); ?></h1>

                                    </div>
                                </div>
                            </article>
                        <?php endwhile;
                        wp_reset_postdata(); ?>
                    </div>
                </div>
            <?php endif; ?>
        </section>
    <?php endforeach;
endif;
?>


<?php get_footer(); ?>



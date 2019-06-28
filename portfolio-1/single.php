<?php get_header(); ?>
<section>
    <div class="container">
        <?php if (have_posts()): ?>
            <?php while (have_posts()): the_post(); ?>
                <div class="row">
                    <div class="col-12">
                        <!-- Affiche le titre de l'article -->
                        <h1><?php the_title(); ?></h1>
                        <!-- Appel la function date -->
                        <p>
                            <?php echo jpm_give_me_meta_01(
                                esc_attr(get_the_date('c')),
                                esc_html(get_the_date()),
                                get_the_category_list(', '),
                                get_the_tag_list('', ', ')
                            ); ?>
                        </p>
                        <!-- Affiche le début de l'article -->
                        <?php the_content(); ?>
                    </div><!-- /col-12 -->
                </div><!-- /row -->
            <?php endwhile;
            wp_reset_postdata(); ?>
            <div class="row">
                <div class="col-12">
                    <nav class="d-flex justify-content-between">
                        <div class=""><?php previous_post_link(); ?></div>
                        <div class=""><?php next_post_link(); ?></div>
                    </nav>
                </div><!-- /col-12 -->
            </div><!-- /row -->
        <?php else: ?>
            <div class="row">
                <div class="col-12">
                    <p>il n'y a pas de résultats !</p>
                </div>
            </div>
        <?php endif; ?>
    </div><!-- /container -->
</section>

<?php get_footer(); ?>
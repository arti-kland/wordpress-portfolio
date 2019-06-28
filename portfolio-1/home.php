
<?php get_header(); ?>
<section>
    <div class="container">
        <?php if (have_posts()): ?>
            <?php while (have_posts()): the_post(); ?>

                <!-- affiche le contenu du fichier content.php -->
                <?php get_template_part('content'); ?>

            <?php endwhile; wp_reset_postdata();?>

        <?php else: ?>
            <div class="row">
                <div class="col-12">
                    <p>il n'y a pas de résultats !</p>
                </div>
            </div>
        <?php endif; ?>

        <div class="row">
           <?php jpm_pagination(); ?>
        </div><!-- /row -->

    </div><!-- /container -->
</section>

<?php get_footer(); ?>
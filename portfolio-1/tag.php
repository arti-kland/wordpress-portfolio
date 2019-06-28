<?php get_header(); ?>
<section>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <p class="lead">Liste des articles avec l'étiquette : <?php single_tag_title(''); ?></p>
            </div>
        </div>
        <?php if (have_posts()): ?>
            <?php while (have_posts()): the_post(); ?>
                <!-- affiche le contenu du fichier content.php -->
                <?php get_template_part('content'); ?>
            <?php endwhile; ?>
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
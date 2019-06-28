<?php get_header(); ?>

<section>
    <div class="container">
        <?php if (have_posts()):; ?>
            <?php while (have_posts()) :
                the_post();
                $alt_text = get_post_meta($post->ID, '_wp_attachment_image_alt', true);
                $big_metadata = wp_get_attachment_metadata($post->ID);

                $month_upload = substr($big_metadata['file'], 0, 7);
                $base_path = wp_upload_dir($month_upload)['url'] . '/';
                $full_file = $base_path . substr($big_metadata['file'], 8);
                //        echo $base_path;
                ?>
                <div class="row">
                    <div class="col-12">
                        <h1>Image principale</h1>
                    </div>
                    <div class="col-sm-2 col-md-4">
                        <img class="img-fluid img-thumbnail" src="<?php echo $full_file; ?>" alt="">
                    </div>
                    <div class="col-sm-10 col-md-8">
                        <h2 class="h2"><?php the_title(); ?></h2>
                        <p><b>width: </b><?php echo $big_metadata['width']; ?>
                            <b>heigth: </b><?php echo $big_metadata['height']; ?></p>
                        <p><b>Image principale</b> (id:<?php echo $post->ID; ?>) <?php echo $full_file; ?></p>

                        <div>
                            <b>contenu:</b> <?php the_content(); ?>
                        </div>
                        <div>
                            <b>extrait:</b> <?php the_excerpt(); ?>
                        </div>
                        <div>
                            <p>téléversée le <?php echo esc_html(get_the_date()); ?></p>
                            <b>texte alternatif:</b> <?php echo $alt_text; ?>
                        </div>
                    </div>
                </div>

                <?php if (current_user_can('edit_post')): ?>

                <div class="row">
                    <div class="col-12">
                        <h1>Autres tailles</h1>
                    </div>

                    <?php foreach ($big_metadata['sizes'] as $key => $value) : ?>
                        <div class="col-12">
                            <h2><?php echo $key; ?></h2>
                            <p><?php echo $base_path . $value['file']; ?></p>
                            <p class="lead text-center"><b><?php echo $value['width']; ?> X <?php echo $value['height']; ?></b></p>
                        </div>
                        <div class="col-sm-2 col-md-4">
                            <img class="img-fluid img-thumbnail" src="<?php echo $base_path . $value['file']; ?>"
                                 alt="<?php echo $alt_text; ?>">
                        </div>
                    <?php endforeach; ?>
                </div><!-- /row -->

            <?php endif; // can edit post
                ?>

            <?php endwhile; // boucle principale ?>

        <?php else: ?>
            <div class="row">
                <div class="col-12">
                    <p>il n'y a pas de résultats</p>
                </div>
            </div><!-- /row -->
        <?php endif; ?>
    </div><!-- /container -->
</section>

<?php get_footer(); ?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Portfolio de jean-philippe Mauviel">

    <?php wp_head(); ?>

</head>
<body>
<header>
    <nav class="navbar navbar-expand-md navbar-dark mb-4">
        <a class="navbar-brand" href="#">Top navbar</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse"
                aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <?php
        wp_nav_menu(array(
                'menu' => 'top-menu',
                'theme_location' => 'primary',
                'depth' => 2,
                'container' => 'div',
                'container_class' => 'navbar-collapse collapse',
                'container_id' => 'navbarCollapse',
                'menu_class' => 'nav navbar-nav',
                'fallback_cb' => 'wp_bootstrap_navwalker::fallback',
                'walker' => new wp_bootstrap_navwalker()
            )
        ); ?>
    </nav>

</header>
<section>
    <?php if (isset($_SESSION['contact-result'])): ?>
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="bg-success text-white text-center p-3 mb-3">
                        <p class="bm-0"><?php echo $_SESSION['contact-result']; ?></p>
                    </div>
                </div>
            </div><!-- /row -->
        </div><!-- /container -->
    <?php endif; ?>

    <div class="container">
        <div class="jumbotron">

            <?php $theme_opts = get_option('jpm_opts'); ?>

            <div class="row">
                <div class="col-4">
                    <img class="img-fluid" src="<?php echo $theme_opts['image_01_url']; ?>" alt=""
                    <p class="text-center"><?php echo stripslashes($theme_opts['legend_01']); ?></p>
                </div>
                <div class="col-8">
                    <h1 class="m-up-reset">Mon Portfolio</h1>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                        labore
                        et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi
                        ut
                        aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                        cillum
                        dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa
                        qui officia
                        deserunt mollit anim id est laborum.</p>
                </div>
            </div><!-- /row -->
        </div>
    </div><!-- /container -->
</section>
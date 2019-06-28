<?php

function jpm_save_options() {


    if(!current_user_can('publish_pages')) {
        wp_die('Vous n\'êtes pas autorisé à effectuer cette opération');
    }
    check_admin_referer('jpm_options_verify');

    $opts = get_option('jpm_opts');

    // sauvegarde de  légende
    $opts['legend_01'] = sanitize_text_field($_POST["jpm_legend_01"]);

    // sauvegarde image
    $opts['image_01_url'] = sanitize_text_field($_POST['jpm_image_url_01']);

    update_option('jpm_opts', $opts);

    wp_redirect(admin_url('admin.php?page=jpm_theme_opts&status=1'));
    exit;

}// fin de la function jpm_save_options
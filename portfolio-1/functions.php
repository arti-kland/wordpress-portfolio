<?php
//===================================================================================================================
//                                            Ajout gestion des session PHP
//===================================================================================================================

function jpm_session_start()
{
    if (!session_id()) {
        session_start();
    }
}

add_action('init', 'jpm_session_start', 1);

//===================================================================================================================
//                                                 Chargement des scripts
//===================================================================================================================

define('JPM_VERSION', '1.0.0');

////Chargement dans le front-end////
function jpm_scripts()
{

    ////Chargement des styles////
    wp_enqueue_style('jpm_bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', array(), JPM_VERSION, 'all');

    if (is_front_page()) :
        wp_enqueue_style('jpm_animate', get_template_directory_uri() . '/css/animate.css', array(), JPM_VERSION, 'all');
        wp_enqueue_style('jpm_style', get_template_directory_uri() . '/style.css', array('jpm_bootstrap', 'jpm_animate'), JPM_VERSION, 'all');

    else:
        wp_enqueue_style('jpm_style', get_template_directory_uri() . '/style.css', array('jpm_bootstrap'), JPM_VERSION, 'all');
    endif;

    ////Chargement des scripts////
    wp_enqueue_script('bootstrap-js', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'), JPM_VERSION, true);

    wp_enqueue_script('jpm_admin_scripts', get_template_directory_uri() . '/js/script.js', array('jquery', 'bootstrap-js'), JPM_VERSION, true);


}////Fin de function jpm_scripts////

add_action('wp_enqueue_scripts', 'jpm_scripts');


//===================================================================================================================
//                                          Chargement des styles/scripts dashboard
//===================================================================================================================
function jpm_admin_init()
{
    //********action 1
    function jpm_admin_scripts()
    {
      if (isset($_GET['page']) && ($_GET['page'] == "jpm_theme_opts" || $_GET['page'] == "messages_recus")) :

            ////Chargement des styles admin
            wp_enqueue_style('jpm_bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', array(), JPM_VERSION, 'all');

            // chargement des scipts admin
            wp_enqueue_media();
            wp_enqueue_script('jpm-admin-init', get_template_directory_uri() . '/js/admin-options.js', array(), JPM_VERSION, true);
        endif;
    }////Fin de function jpm_admin_scripts////

    add_action('admin_enqueue_scripts', 'jpm_admin_scripts');

    //********action 2
    include('includes/save-options-page.php'); // contien la function jpm_save_options
    add_action('admin_post_jpm_save_options', 'jpm_save_options');

}//// fin de la function jpm_admin_init

add_action('admin_init', 'jpm_admin_init');

//===================================================================================================================
//                                     opération pour le formulaire de contacts
//===================================================================================================================
include('includes/build-contact-form.php');


//===================================================================================================================
//                                               Activation des options
//===================================================================================================================

function jpm_activ_options()
{

    $theme_opts = get_option('jpm_opts');
    if (!$theme_opts) {
        $opts = array(
            'image_01_url' => '',
            'legend_01' => ''
        );
        add_option('jpm_opts', $opts);
    }
}

add_action('after_switch_theme', 'jpm_activ_options');

//===================================================================================================================
//                                               Menu options du thème
//===================================================================================================================

function jpm_admin_menus()
{
    add_menu_page(
        'portfolio-1 Options',
        'Options du thème',
        'publish_pages',
        'jpm_theme_opts',
        'jpm_build_options_page'
    );
    include('includes/build-options-page.php');

}//// fin de la function jpm_admin_menus
add_action('admin_menu', 'jpm_admin_menus');

//===================================================================================================================
//                                               Sidebars end Widgetized
//===================================================================================================================

function jpm_widgets_init()
{
    register_sidebar(array(
        'name' => 'Footer Widget Zone',
        'description' => 'Widgets affichés dans le footer: 4 au maximum',
        'id' => 'widgetized-footer',
        'before_widget' => '<div id="%1$s" class="box col-xs-12 col-sm-6 col-md-3 %2$s"><div class="inside-widget">',
        'after_widget' => '</div></div>',
        'before_title' => '<h2 class="h3 text-center">',
        'after_title' => '</h2>',

    ));
}

add_action('widgets_init', 'jpm_widgets_init');

//===================================================================================================================
//                                                    Utilitaires
//===================================================================================================================

function jpm_setup()
{

    //support des vignettes
    add_theme_support('post-thumbnails');

    //crée format image slider front
    add_image_size('up-medium-true', 500, 375, true);
    add_image_size('up-medium-false', 500, 375, false);

    add_image_size('front-slider', 1140, 420, true);
    add_image_size('article', 500, 300, true);

    //enlève générateur de version
    remove_action('wp_head', 'wp_generator');

    //enlève les guillemets à la française
    remove_filter('the_content', 'wptexturize');

    //support du titre
    add_theme_support('title-tag');

    //Register Custom Navigation Walker
    require_once('includes/wp_bootstrap_navwalker.php');

    //active la gestion des menus
    register_nav_menus(array('primary' => 'principal'));

}//fin function jpm_setup

add_action('after_setup_theme', 'jpm_setup');


///install menu button in themes on DashBoard /////
add_theme_support('menus');

//===================================================================================================================
//                                             Ajoute la taille Medium Large dans la selection
//===================================================================================================================

function my_images_sizes($sizes)
{
    $addSizes = array(
        "medium_large" => "Medium Large"
    );
    $newSizes = array_merge($sizes, $addSizes);
    return $newSizes;
}//fin function my_images_sizes

add_filter('image_size_names_choose', 'my_images_sizes');


//===================================================================================================================
//                                                     Affichage date
//===================================================================================================================

function jpm_give_me_meta_01($date1, $date2, $cat, $tags)
{
    $chaine = 'publié le <time class="entry-date" datetime="';
    $chaine .= $date1;
    $chaine .= '">';
    $chaine .= $date2;
    $chaine .= '</time> dans la catégorie : ';
    $chaine .= $cat;
    if (strlen($tags) > 0):
        $chaine .= '<br>avec les étiquettes : ' . $tags;
    endif;
    return $chaine;
}


//===================================================================================================================
//                                              Modifie le texte de suite de l'excerpt
//===================================================================================================================


function jpm_new_excerpt_more($more)
{
    return ' <a class="more-link" href="' . get_permalink() . '">' . ' lire la suite' . '</a>';
}

add_filter('excerpt_more', 'jpm_new_excerpt_more');

//===================================================================================================================
//                                              Pagination
//===================================================================================================================


function jpm_pagination()
{
    global $wp_query;
    $big = 999999999;
    $total_pages = $wp_query->max_num_pages;
    if ($total_pages > 1):
        echo paginate_links(array(
            'base' => str_replace($big, ' %#% ', esc_url(get_pagenum_link($big))),
            'format' => ' /page/%#% ',
            'current' => max(1, get_query_var('paged')),
            'total' => $total_pages,
            'prev_next' => true,
            'prev_text' => '<< Page précédente ',
            'next_text' => ' Page suivante >>'
        ));

    endif; //fin bloc pagination
}

//===================================================================================================================
//                                              CPT slider front page d'acceuil
//===================================================================================================================

function jpm_slider_init()
{

    $labels = array(
        'name' => 'Image Carousel Acceuil',
        'singular_name' => 'Image acceuil',
        'add_new' => 'Ajouter une image',
        'add_new_item' => 'Ajouter une Image acceuil',
        'edit_item' => 'Modifier Image acceuil',
        'new_item' => 'Nouveau',
        'all_items' => 'Voir la liste',
        'view_item' => 'Voir l\'élément',
        'search_item' => 'Chercher une Imageacceuil',
        'not_found' => 'Aucun élément trouvé',
        'not_found_in-trash' => 'Aucun élément dans la corbeille',
        'menu_name' => 'Slider Frontal'
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => true,
        'capability_type' => 'post',
        'has_archive' => false,
        'hierachical' => false,
        'menu_position' => 20,
        'publicly_queryable' => false,
        'exclude_from_search' => true,
        'supports' => array('title', 'editor', 'page-attributes', 'thumbnail')
    );

    register_post_type('jpm_slider', $args);
} // end function jpm_slider_init

add_action('init', 'jpm_slider_init');

//===================================================================================================================
//                                Ajout de l'image et ordre dans la colonne admin pour le slider
//===================================================================================================================

add_filter('manage_edit-jpm_slider_columns', 'jpm_col_change');

function jpm_col_change($columns)
{
    $columns['jpm_slider_image_order'] = "ordre";
    $columns['jpm_slider_image'] = "image affichée";

    return $columns;
}


add_action('manage_jpm_slider_posts_custom_column', 'jpm_content_show', 10, 2);

function jpm_content_show($column, $post_id)
{
    global $post;

    if ($column == 'jpm_slider_image') {
        echo the_post_thumbnail(array(100, 100));
    }
    if ($column == 'jpm_slider_image_order') {
        echo $post->menu_order;
    }
}


//===================================================================================================================
//                                Tri auto sur l'ordre dans la colonne du slider
//===================================================================================================================

function jpm_change_slides_order($query)
{
    global $post_type, $pagenow;

    if ($pagenow == 'edit.php' && $post_type == 'jpm_slider') {
        $query->query_vars['orderby'] = 'menu_order';
        $query->query_vars['order'] = 'asc';
    }
}

add_action('pre_get_posts', 'jpm_change_slides_order');


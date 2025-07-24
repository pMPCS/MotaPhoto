<?php
// Charger le style principal
function motaphoto_enqueue_styles() {
    wp_enqueue_style('motaphoto-style', get_stylesheet_uri());
    wp_enqueue_script('motaphoto-script', get_template_directory_uri() . '/assets/js/scripts.js', ['jquery'], false, true);
     wp_localize_script('motaphoto-script', 'ajaxurl', admin_url('admin-ajax.php'));
}
add_action('wp_enqueue_scripts', 'motaphoto_enqueue_styles');

// Déclarer le menu principal
function motaphoto_register_menus() {
    register_nav_menus([
        'main_menu'    => 'Menu principal',
        'footer_menu'  => 'Menu pied de page'
    ]);
}
add_action('after_setup_theme', 'motaphoto_register_menus');


function load_more_photos_callback() {
    $paged = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $photos = new WP_Query([
        'post_type'      => 'photo',
        'posts_per_page' => 8,
        'paged'          => $paged,
        'orderby'        => 'date',
        'order'          => 'DESC'
    ]);
    ob_start();
    if ($photos->have_posts()) :
        while ($photos->have_posts()) : $photos->the_post();
            get_template_part('template_parts/photo_block');
        endwhile;
    endif;
    wp_reset_postdata();
    echo ob_get_clean();
    wp_die();
}
add_action('wp_ajax_load_more_photos', 'load_more_photos_callback');
add_action('wp_ajax_nopriv_load_more_photos', 'load_more_photos_callback');
<?php
// Charger le style principal
function motaphoto_enqueue_styles() {
    wp_enqueue_style('motaphoto-style', get_stylesheet_uri());
    wp_enqueue_script('motaphoto-script', get_template_directory_uri() . '/assets/js/scripts.js', ['jquery'], false, true);
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
<?php
// Charger le style principal
function motaphoto_enqueue_styles() {
    wp_enqueue_style('motaphoto-style', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts', 'motaphoto_enqueue_styles');

// Déclarer le menu principal
function motaphoto_register_menus() {
    register_nav_menus([
        'main_menu' => 'Menu principal'
    ]);
}
add_action('after_setup_theme', 'motaphoto_register_menus');
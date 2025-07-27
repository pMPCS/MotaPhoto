<?php
// Charger le style principal et les scripts
function motaphoto_enqueue_styles() {
    wp_enqueue_style('motaphoto-style', get_stylesheet_uri());
    wp_enqueue_script(
        'motaphoto-script',
        get_template_directory_uri() . '/assets/js/scripts.js',
        ['jquery'],
        false,
        true
    );
    // Injection d'ajaxurl pour le JS en front
    wp_localize_script('motaphoto-script', 'ajaxurl', admin_url('admin-ajax.php'));
}
add_action('wp_enqueue_scripts', 'motaphoto_enqueue_styles');

// Déclarer les menus
function motaphoto_register_menus() {
    register_nav_menus([
        'main_menu'    => 'Menu principal',
        'footer_menu'  => 'Menu pied de page'
    ]);
}
add_action('after_setup_theme', 'motaphoto_register_menus');


// AJAX pour charger les photos paginées & filtrées
function motaphoto_filter_photos_callback() {
    // Pour le bouton "Charger plus" ET pour les filtres
    // Utilise $_POST (ajax), mais tolère $_GET pour compatibilité avec ancien code
    $paged = isset($_POST['page']) ? intval($_POST['page']) : (isset($_GET['page']) ? intval($_GET['page']) : 1);

    // Filtres
    $categorie = isset($_POST['categorie']) ? intval($_POST['categorie']) : '';
    $format    = isset($_POST['format'])    ? intval($_POST['format'])    : '';
    $tri       = (isset($_POST['tri']) && $_POST['tri'] === 'anciennes') ? 'ASC' : 'DESC';

    $args = [
        'post_type'      => 'photo',
        'posts_per_page' => 8,
        'paged'          => $paged,
        'orderby'        => 'date',
        'order'          => $tri,
    ];

    // Tax queries pour les filtres
    $tax_query = [];
    if ($categorie) {
        $tax_query[] = [
            'taxonomy' => 'categorie',
            'field'    => 'term_id',
            'terms'    => $categorie,
        ];
    }
    if ($format) {
        $tax_query[] = [
            'taxonomy' => 'format',
            'field'    => 'term_id',
            'terms'    => $format,
        ];
    }
    if ($tax_query) $args['tax_query'] = $tax_query;

    $photos = new WP_Query($args);

    ob_start();
    if ($photos->have_posts()) :
        while ($photos->have_posts()) : $photos->the_post();
            get_template_part('template_parts/photo_block');
        endwhile;
    else :
        echo '<p>Aucune photo trouvée.</p>';
    endif;
    wp_reset_postdata();
    echo ob_get_clean();
    wp_die();
}
add_action('wp_ajax_motaphoto_filter_photos', 'motaphoto_filter_photos_callback');
add_action('wp_ajax_nopriv_motaphoto_filter_photos', 'motaphoto_filter_photos_callback');
add_action('wp_enqueue_scripts', function() {
    wp_localize_script('motaphoto-script', 'ajaxurl', admin_url('admin-ajax.php'));
});
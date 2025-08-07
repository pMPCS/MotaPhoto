<?php
// ======= CHARGEMENT DES STYLES ET SCRIPTS =======
function motaphoto_enqueue_styles() {
    // Charge le style principal du thème (style.css)
    wp_enqueue_style('motaphoto-style', get_stylesheet_uri());
    // Charge le JS principal (scripts.js) avec dépendance à jQuery, en pied de page (true)
    wp_enqueue_script(
        'motaphoto-script',
        get_template_directory_uri() . '/assets/js/scripts.js',
        ['jquery'],
        false,
        true
    );
    // Permet d’utiliser “ajaxurl” côté JS pour faire des appels AJAX à WP
    wp_localize_script('motaphoto-script', 'ajaxurl', admin_url('admin-ajax.php'));
}
// On accroche cette fonction au hook WordPress pour charger les scripts/styles côté front
add_action('wp_enqueue_scripts', 'motaphoto_enqueue_styles');


// ======= DÉCLARATION DES MENUS PERSONNALISÉS =======
function motaphoto_register_menus() {
    register_nav_menus([
        'main_menu'    => 'Menu principal',
        'footer_menu'  => 'Menu pied de page'
    ]);
}
// On accroche cette fonction à l’initialisation du thème
add_action('after_setup_theme', 'motaphoto_register_menus');


// ======= HANDLER AJAX : FILTRAGE ET PAGINATION DES PHOTOS =======
function motaphoto_filter_photos_callback() {
    // Pour le bouton "Charger plus" ET pour les filtres
    // Utilise $_POST (ajax), mais tolère $_GET pour compatibilité avec ancien code
    $paged = isset($_POST['page']) ? intval($_POST['page']) : (isset($_GET['page']) ? intval($_GET['page']) : 1);

    // Récupère les filtres envoyés via AJAX (catégorie, format, tri)
    $categorie = isset($_POST['categorie']) ? intval($_POST['categorie']) : '';
    $format    = isset($_POST['format'])    ? intval($_POST['format'])    : '';
    $tri       = (isset($_POST['tri']) && $_POST['tri'] === 'anciennes') ? 'ASC' : 'DESC';
    
    // Prépare la requête WP_Query pour trouver les photos filtrées
    $args = [
        'post_type'      => 'photo',
        'posts_per_page' => 8,
        'paged'          => $paged,
        'orderby'        => 'date',
        'order'          => $tri,
    ];

    
    // Prépare les filtres taxonomiques
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
    
    // Exécute la requête personnalisée
    $photos = new WP_Query($args);
    // Capture le rendu HTML généré par chaque photo (photo_block.php)
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
// Déclare la fonction comme handler AJAX pour utilisateurs connectés et non connectés
add_action('wp_ajax_motaphoto_filter_photos', 'motaphoto_filter_photos_callback');
add_action('wp_ajax_nopriv_motaphoto_filter_photos', 'motaphoto_filter_photos_callback');
// (Sécurité) Réinjection d’ajaxurl pour scripts (si d’autres scripts sont ajoutés après coup)
add_action('wp_enqueue_scripts', function() {
    wp_localize_script('motaphoto-script', 'ajaxurl', admin_url('admin-ajax.php'));
});

// ======= CHARGEMENT DU SCRIPT LIGHTBOX =======
function motaphoto_enqueue_lightbox_script() {
    wp_enqueue_script('motaphoto-lightbox', get_template_directory_uri().'/assets/js/lightbox.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'motaphoto_enqueue_lightbox_script');
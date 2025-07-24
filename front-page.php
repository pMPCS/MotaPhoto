<?php
// PAGE ACCUEIL (front-page.php ou page-accueil.php, selon ta structure)
get_header(); // Placer AVANT <main>
?>

<main class="homepage">

    <!-- HERO -->
    <?php
    // Récupère l’image du hero (champ ACF)
    $hero_img = get_field('hero_image');
    if ($hero_img) {
        // $hero_img est un tableau avec URL, ID, etc.
        $hero_img_url = esc_url($hero_img['url']);
        $hero_img_alt = esc_attr($hero_img['alt'] ?? 'Photo hero accueil');
    } else {
        // Fallback si aucune image définie
        $hero_img_url = get_template_directory_uri() . '/assets/images/hero-default.jpg';
        $hero_img_alt = 'Photo hero accueil';
    }
    ?>
    <section class="homepage-hero">
        <div class="homepage-hero-bg">
            <img src="<?php echo $hero_img_url; ?>" alt="<?php echo $hero_img_alt; ?>" />
            <h1 class="homepage-hero-title">PHOTOGRAPH EVENT</h1> <!-- À remplacer par ton vrai titre -->
        </div>
    </section>


    <!-- FILTRES & TRI -->
    <section class="photo-filters">
        <form id="photo-filter-form">
            <select name="categorie" id="filter-categorie">
                <option value="">Toutes les catégories</option>
                <!-- options dynamiques via WP -->
            </select>
            <select name="format" id="filter-format">
                <option value="">Tous les formats</option>
                <!-- options dynamiques via WP -->
            </select>
            <select name="tri" id="filter-tri">
                <option value="recentes">Plus récentes</option>
                <option value="anciennes">Plus anciennes</option>
            </select>
        </form>
    </section>

    <!-- GRILLE DES PHOTOS -->
    <section class="photo-grid-section">
        <div class="photo-grid" id="photo-grid">
            <?php
      // Boucle pour afficher 8 photos (type personnalisé 'photo')
      $photos = new WP_Query([
        'post_type'      => 'photo',
        'posts_per_page' => 8,
        'orderby'        => 'date',
        'order'          => 'DESC'
      ]);

      if ($photos->have_posts()) :
        while ($photos->have_posts()) : $photos->the_post();
          // Appel du template pour chaque bloc photo
          get_template_part('template_parts/photo_block');
        endwhile;
        wp_reset_postdata();
      else :
        echo '<p>Aucune photo trouvée.</p>';
      endif;
    ?>
        </div>
        <button id="load-more-photos" class="photo-load-more">Charger plus</button>
    </section>


</main>

<?php get_footer(); // Placer APRES </main> ?>
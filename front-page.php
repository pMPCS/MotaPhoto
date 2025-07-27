<?php
// PAGE ACCUEIL (front-page.php)
get_header(); 
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
            <h1 class="homepage-hero-title">PHOTOGRAPH EVENT</h1> <!-- Ltitre ici -->
        </div>
    </section>


    <!-- FILTRES & TRI -->
    <section class="photo-filters">
        <form id="photo-filter-form" autocomplete="off">

            <!-- Catégorie -->
            <div class="custom-select" data-type="categorie" tabindex="0">
                <div class="custom-select-selected">CATEGORIES<span class="custom-select-arrow"></span></div>
                <div class="custom-select-dropdown">
                    <?php
                 $cats = get_terms(['taxonomy' => 'categorie', 'hide_empty' => true]);
                 foreach ($cats as $cat) {
                  echo '<div class="custom-select-option" data-value="' . esc_attr($cat->term_id) . '">' . esc_html($cat->name) . '</div>';
                  }
                 ?>
                </div>
                <input type="hidden" name="categorie" value="">
            </div>

            <!-- Format -->
            <div class="custom-select" data-type="format" tabindex="0">
                <div class="custom-select-selected">FORMATS<span class="custom-select-arrow"></span></div>
                <div class="custom-select-dropdown">
                    <?php
          $formats = get_terms(['taxonomy' => 'format', 'hide_empty' => true]);
          foreach ($formats as $format) {
            echo '<div class="custom-select-option" data-value="' . esc_attr($format->term_id) . '">' . esc_html($format->name) . '</div>';
          }
        ?>
                </div>
                <input type="hidden" name="format" value="">
            </div>

            <!-- Tri -->
            <div class="custom-select" data-type="tri" tabindex="0">
                <div class="custom-select-selected">TRIER PAR<span class="custom-select-arrow"></span></div>
                <div class="custom-select-dropdown">
                    <div class="custom-select-option" data-value="recentes">Plus récentes</div>
                    <div class="custom-select-option" data-value="anciennes">Plus anciennes</div>
                </div>
                <input type="hidden" name="tri" value="">
            </div>

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

<?php get_footer();  ?>
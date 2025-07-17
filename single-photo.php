<?php
get_header();

if (have_posts()) : while (have_posts()) : the_post();

// Champs personnalisés
$reference = get_post_meta(get_the_ID(), 'reference', true);
$type = get_post_meta(get_the_ID(), 'type', true);

// Taxonomies
$categories = get_the_terms(get_the_ID(), 'categorie');
$formats = get_the_terms(get_the_ID(), 'format');

// Date native (année)
$date = get_the_date('Y');

// Image à la une (full)
$image_url = get_the_post_thumbnail_url(get_the_ID(), 'full');

?>
<div class="photo-single-container">

    <!-- === Bloc principal (infos à gauche, image à droite) === -->
    <div class="photo-main-block">

        <!-- Colonne infos (gauche) -->
        <div class="photo-infos">
            <div class="photo-infos-content">
                <h1 class="photo-title"><?php the_title(); ?></h1>
                <div class="photo-meta">
                    <div><strong>RÉFÉRENCE :</strong> <?= esc_html($reference); ?></div>
                    <div><strong>CATÉGORIE :</strong> <?= !empty($categories) ? esc_html($categories[0]->name) : ''; ?>
                    </div>
                    <div><strong>FORMAT :</strong> <?= !empty($formats) ? esc_html($formats[0]->name) : ''; ?></div>
                    <div><strong>TYPE :</strong> <?= esc_html($type); ?></div>
                    <div><strong>ANNÉE :</strong> <?= esc_html($date); ?></div>
                </div>
            </div>
        </div>

        <!-- Colonne image (droite) -->
        <div class="photo-image">
            <?php if ($image_url) : ?>
            <img class="photo-img-main" src="<?= esc_url($image_url); ?>" alt="<?= esc_attr(get_the_title()); ?>">
            <?php endif; ?>
        </div>

    </div> <!-- /.photo-main-block -->

    <!-- === Bloc du bas (contact + navigation) === -->
    <div class="photo-bottom-bar"></div>
    <div class="photo-single-bottom">
        <div class="bottom-left">
            <span class="photo-bottom-label">Cette photo vous intéresse&nbsp;?</span>
            <button class="photo-contact-btn open-contact-modal" id="open-contact-modal"
                data-reference="<?= esc_attr($reference); ?>">
                Contact
            </button>
        </div>

        <!-- NAVIGATION (flèches + miniature preview) -->
        <div class="bottom-right">
            <div class="photo-navigation">
                <!-- Bloc pour la miniature centrée au-dessus des flèches -->
                <div class="photo-nav-flags">
                    <div class="photo-nav-thumb-preview"></div>
                </div>
                <!-- Les deux flèches de navigation -->
                <div class="photo-nav-arrows">
                    <?php
                    // Précédent / Suivant dans la même catégorie
                    $prev_post = get_adjacent_post(true, '', true, 'categorie');
                    $next_post = get_adjacent_post(true, '', false, 'categorie');

                    // Icônes SVG ou images (ajuste les chemins si besoin)
                    $svg_left = '<img src="' . get_template_directory_uri() . '/assets/images/Line 6.png" alt="Précédent" class="photo-nav-arrow">';
                    $svg_right = '<img src="' . get_template_directory_uri() . '/assets/images/Line 7.png" alt="Suivant" class="photo-nav-arrow">';

                    // Fonction pour générer le lien de navigation avec thumbnail en data-thumb
                    function photo_nav_link($post, $svg_icon) {
                        if ($post) {
                            $img = get_the_post_thumbnail_url($post->ID, 'thumbnail');
                            echo '<a href="' . get_permalink($post->ID) . '" class="photo-nav-link" data-thumb="' . esc_url($img) . '">';
                            echo $svg_icon;
                            echo '</a>';
                        }
                    }

                    photo_nav_link($prev_post, $svg_left);
                    photo_nav_link($next_post, $svg_right);
                    ?>
                </div>
            </div>
        </div>
    </div>

    <div class="photo-bottom-bar-large"></div>

    <!-- === Bloc apparentées (photos de la même catégorie) === -->
    <div class="photo-apparentees-section">
        <h2>Vous aimerez aussi</h2>
        <div class="photo-apparentees-list">
            <?php
            // 2 photos de la même catégorie, hors photo courante
            $related = new WP_Query([
                'post_type' => 'photo',
                'posts_per_page' => 2,
                'post__not_in' => [get_the_ID()],
                'tax_query' => [
                    [
                        'taxonomy' => 'categorie',
                        'field' => 'term_id',
                        'terms' => !empty($categories) ? $categories[0]->term_id : [],
                    ]
                ],
            ]);
            if ($related->have_posts()) :
                while ($related->have_posts()) : $related->the_post();
                    get_template_part('template_parts/photo_block');
                endwhile;
                wp_reset_postdata();
            endif;
            ?>
        </div>
    </div>
</div>
<?php endwhile; endif; get_footer(); ?>
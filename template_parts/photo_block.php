<?php
// Récupère l’URL de l’image principale (la “featured image” WordPress), taille “large”
$image_url = get_the_post_thumbnail_url(get_the_ID(), 'large');
// Récupère toutes les catégories (termes) associées à cette photo (taxonomy “categorie”)
$categories = get_the_terms(get_the_ID(), 'categorie');
?>
<div class="photo-block">
    <div class="photo-block-image">
        <!-- Affichage de la photo principale -->
        <img src="<?= esc_url($image_url); ?>" alt="<?= esc_attr(get_the_title()); ?>">
        <div class="photo-block-overlay">
            <!-- Icône FULLSCREEN en haut à droite (ouvre la lightbox en plein écran) -->
            <a href="<?= esc_url($image_url); ?>" class="photo-block-icon fullscreen" title="Voir en grand"
                data-lightbox="photo" data-photo-id="<?= get_the_ID(); ?>" data-photo-src="<?= esc_url($image_url); ?>"
                data-photo-title="<?= esc_attr(get_the_title()); ?>"
                data-photo-ref="<?= esc_attr(get_post_meta(get_the_ID(), 'reference', true)); ?>"
                data-photo-category="<?= !empty($categories) ? esc_attr($categories[0]->name) : ''; ?>">
                <img src="<?= get_template_directory_uri(); ?>/assets/images/fullscreen_icon.png" alt="Voir en grand"
                    width="28" height="28">
            </a>

            <!-- Icône OEIL au centre (voir la fiche de la photo) -->
            <a href="<?php the_permalink(); ?>" class="photo-block-icon eye" title="Voir les infos">
                <img src="<?= get_template_directory_uri(); ?>/assets/images/icon_eye.png" alt="Voir les infos"
                    width="28" height="28">
            </a>
            <!-- Métadonnées affichées en bas du bloc overlay -->
            <div class="photo-block-overlay-meta">
                <div class="photo-block-title"><?= esc_html(get_the_title()); ?></div>
                <div class="photo-block-category"><?= !empty($categories) ? esc_html($categories[0]->name) : ''; ?>
                </div>
            </div>
        </div>
    </div>
</div>
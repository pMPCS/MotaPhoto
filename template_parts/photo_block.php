<?php
$image_url = get_the_post_thumbnail_url(get_the_ID(), 'large');
$categories = get_the_terms(get_the_ID(), 'categorie');
?>
<div class="photo-block">
    <div class="photo-block-image">
        <img src="<?= esc_url($image_url); ?>" alt="<?= esc_attr(get_the_title()); ?>">
        <div class="photo-block-overlay">
            <!-- Icône FULLSCREEN en haut à droite -->
            <a href="<?= esc_url($image_url); ?>" class="photo-block-icon fullscreen" title="Voir en grand"
                data-lightbox="photo">
                <img src="<?= get_template_directory_uri(); ?>/assets/images/fullscreen_icon.png" alt="Voir en grand"
                    width="28" height="28">
            </a>
            <!-- Icône OEIL au centre -->
            <a href="<?php the_permalink(); ?>" class="photo-block-icon eye" title="Voir les infos">
                <img src="<?= get_template_directory_uri(); ?>/assets/images/icon_eye.png" alt="Voir les infos"
                    width="28" height="28">
            </a>
            <!-- Métas en bas (ligne) -->
            <div class="photo-block-overlay-meta">
                <div class="photo-block-title"><?= esc_html(get_the_title()); ?></div>
                <div class="photo-block-category"><?= !empty($categories) ? esc_html($categories[0]->name) : ''; ?>
                </div>
            </div>
        </div>
    </div>
</div>
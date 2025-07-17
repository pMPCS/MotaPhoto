<?php
// À inclure avec the_post() déjà positionné
$image_url = get_the_post_thumbnail_url(get_the_ID(), 'large');
$reference = get_post_meta(get_the_ID(), 'reference', true);
?>
<div class="photo-block">
    <div class="photo-block-image">
        <img src="<?= esc_url($image_url); ?>" alt="<?= esc_attr(get_the_title()); ?>">
        <div class="photo-block-overlay">
            <a href="<?php the_permalink(); ?>" class="photo-block-icon eye" title="Voir les infos"><span>👁️</span></a>
            <a href="<?= esc_url($image_url); ?>" class="photo-block-icon fullscreen" title="Voir en grand"
                data-lightbox="photo"><span>⛶</span></a>
        </div>
    </div>
    <div class="photo-block-title"><?= esc_html(get_the_title()); ?></div>
    <div class="photo-block-ref"><?= esc_html($reference); ?></div>
</div>
<?php get_header(); ?>
<main>
    <?php
    if (have_posts()) :
        while (have_posts()) : the_post();
            the_title('<h1>', '</h1>');
            if (has_post_thumbnail()) {
                the_post_thumbnail('large');
            }
            the_content();
            // Navigation articles suivants/précédents :
            the_post_navigation();
            // Afficher les commentaires si activés :
            if (comments_open() || get_comments_number()) {
                comments_template();
            }
        endwhile;
    endif;
    ?>
</main>
<?php get_footer(); ?>
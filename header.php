<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <header>
        <div class="logo">
            <a href="<?php echo home_url(); ?>">
                <!-- Le logo, tu mettras l’image plus tard -->
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo.svg" alt="Logo">
            </a>
        </div>
        <nav>
            <?php
        wp_nav_menu([
            'theme_location' => 'main_menu',
            'container' => false
        ]);
        ?>
        </nav>
    </header>
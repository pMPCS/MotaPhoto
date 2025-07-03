<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php wp_title('|', true, 'right'); ?><?php bloginfo('name'); ?></title>
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <header class="site-header">
        <div class="header-container">
            <div class="logo">
                <a href="<?php echo home_url(); ?>">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.png" alt="MotaPhoto"
                        height="50">
                </a>
            </div>

            <button class="burger" aria-label="Ouvrir le menu" aria-expanded="false" aria-controls="main-menu">
                <span></span>
                <span></span>
                <span></span>
            </button>

            <nav class="main-nav">
                <?php
            wp_nav_menu([
                'theme_location' => 'main_menu',
                'menu_class'     => 'main-menu',
                'menu_id'        => 'main-menu',
                'container'      => false
            ]);
            ?>
            </nav>
        </div>
    </header>
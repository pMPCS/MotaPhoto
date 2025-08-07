<!-- ========= Entête du document HTML ========= -->
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php wp_title('|', true, 'right'); ?><?php bloginfo('name'); ?></title>
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <!-- ========= Header du site (bandeau du haut) ========= -->
    <header class="site-header">
        <div class="header-container">
            <!-- Logo du site, cliquable (retour à l'accueil) -->
            <div class="logo">
                <a href="<?php echo home_url(); ?>">
                    <!-- Lien vers la page d’accueil -->
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.png" alt="MotaPhoto"
                        height="50">
                </a>
            </div>
            <!-- ===== Menu burger (mobile) pour l’accessibilité et le responsive ===== -->
            <button class="burger" aria-label="Ouvrir le menu" aria-expanded="false" aria-controls="main-menu">
                <span></span>
                <span></span>
                <span></span>
            </button>
            <!-- ===== Menu principal de navigation ===== -->
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
        <!-- ===== Ombre portée décorative sous le header ===== -->
        <div class="header-shadow"></div>
    </header>
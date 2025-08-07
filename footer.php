<!-- ========= Pied de page du site ========= -->
<footer class="site-footer">
    <div class="footer-container">
        <!-- ===== Navigation de pied de page (menu éditable dans WordPress) ===== -->
        <nav class="footer-nav">
            <?php
            wp_nav_menu([
                'theme_location' => 'footer_menu',
                'menu_class'     => 'footer-menu',
                'container'      => false
            ]);
            ?>
        </nav>
        <!-- ===== Bordure décorative pour séparer visuellement le footer du contenu principal ===== -->
        <div class="footer-border"></div>
    </div>
</footer>
<!-- ===== Inclusion de la modale de contact (réutilisable sur toutes les pages) ===== -->
<?php get_template_part('template_parts/contact-modal'); ?>
<!-- Cette ligne inclut le fichier contact-modal.php (modale de contact) dans chaque page. -->
<!-- ===== Appel au hook wp_footer() (WordPress et plugins) ===== -->
<?php wp_footer(); ?>
<!-- Cette fonction insère tous les scripts et éléments nécessaires avant </body> : JS, trackers, fonctionnalités des plugins, etc. -->
<!-- ===== LIGHTBOX MODALE (overlay pour l’affichage plein écran des photos) ===== -->
<div id="lightbox-overlay" style="display: none;">
    <div class="lightbox-content">
        <!-- ===== Flèche gauche pour naviguer vers la photo précédente ===== -->
        <button class="lightbox-arrow lightbox-arrow-left" type="button">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/arrow_left.svg" alt="Précédent"
                class="lightbox-svg-arrow" />
            <span class="lightbox-label">Précédente</span>
        </button>
        <!-- ===== Photo affichée en grand + infos associées ===== -->
        <div class="lightbox-photo-container">
            <img class="lightbox-photo" src="" alt="" />
            <div class="lightbox-meta">
                <span class="lightbox-ref"></span>
                <span class="lightbox-category"></span>
            </div>
        </div>
        <!-- ===== Flèche droite pour naviguer vers la photo suivante ===== -->
        <button class="lightbox-arrow lightbox-arrow-right" type="button">
            <span class="lightbox-label">Suivante</span>
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/arrow_right.svg" alt="Suivant"
                class="lightbox-svg-arrow" />
        </button>
    </div>
    <!-- ===== Bouton de fermeture de la lightbox (croix) ===== -->
    <button class="lightbox-close" aria-label="Fermer">&times;</button>
</div>

</body>

</html>
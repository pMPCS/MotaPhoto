<footer class="site-footer">
    <div class="footer-container">
        <nav class="footer-nav">
            <?php
            wp_nav_menu([
                'theme_location' => 'footer_menu',
                'menu_class'     => 'footer-menu',
                'container'      => false
            ]);
            ?>
        </nav>
    </div>
</footer>

<?php get_template_part('template_parts/contact-modal'); ?>

<?php wp_footer(); ?>
</body>

</html>
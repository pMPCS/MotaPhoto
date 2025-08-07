<!-- ========= MODALE DE CONTACT ========= -->
<div class="contact-modal-backdrop" id="contact-modal-backdrop" style="display:none;">
    <!-- Fenêtre modale proprement dite -->
    <div class="contact-modal" role="dialog" aria-modal="true" aria-labelledby="contact-modal-title">
        <!-- Bouton de fermeture (croix) -->
        <button class="modal-close" id="contact-modal-close" aria-label="Fermer">&times;</button>
        <!-- Le formulaire de contact (inséré par shortcode WordPress) -->
        <?php echo do_shortcode('[form id="25"]'); ?>
    </div>
</div>
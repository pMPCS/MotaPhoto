// ======== LIGHTBOX PHOTO : affichage plein écran des photos ========

document.addEventListener('DOMContentLoaded', function() {
  // 1. Fonction utilitaire pour récupérer tous les liens d’images à afficher en lightbox
  function getAllPhotoLinks() {
    // On sélectionne tous les liens <a> qui ont l’attribut data-lightbox="photo"
    return Array.from(document.querySelectorAll('a[data-lightbox="photo"]'));
  }

  let currentIndex = 0; // Index de la photo affichée dans la lightbox (commence à 0)
  let photos = getAllPhotoLinks(); // Liste des liens vers les photos à afficher

  // 2. Fonction pour ouvrir la lightbox à un certain index
  function openLightbox(index) {
    photos = getAllPhotoLinks(); // Met à jour la liste en cas de changements dynamiques sur la page
    const link = photos[index]; // On récupère le lien cliqué
    if (!link) return; // Si le lien n’existe pas (erreur), on arrête

    // On récupère les infos utiles via les attributs data-* du lien photo
    const src = link.getAttribute('data-photo-src') || link.href; // URL de la photo grand format
    const ref = link.getAttribute('data-photo-ref') || ''; // Référence de la photo
    const cat = link.getAttribute('data-photo-category') || ''; // Catégorie de la photo

    // On remplit la lightbox avec la photo et ses infos
    document.querySelector('.lightbox-photo').src = src; // On met l’image dans la lightbox
    document.querySelector('.lightbox-ref').textContent = ref ? 'Réf : ' + ref : ''; // Référence, si elle existe
    document.querySelector('.lightbox-category').textContent = cat || ''; // Catégorie
    document.getElementById('lightbox-overlay').style.display = 'flex'; // On affiche la lightbox (flex pour centrer)
    document.body.style.overflow = 'hidden'; // On empêche de scroller la page en fond
    currentIndex = index; // On mémorise la position de la photo affichée
  }

  // 3. Clique sur une image : ouverture de la lightbox
  document.body.addEventListener('click', function(e) {
    // On cherche si le clic est sur (ou dans) un lien data-lightbox="photo"
    const target = e.target.closest('a[data-lightbox="photo"]');
    if (target) {
      e.preventDefault(); // Empêche d’aller vers le lien d’origine
      photos = getAllPhotoLinks(); // Met à jour la liste des photos (robuste si des éléments changent)
      const index = photos.indexOf(target); // On retrouve l’index du lien cliqué
      if (index !== -1) openLightbox(index); // Si l’index existe, on ouvre la lightbox dessus
    }
  });

  // 4. Fermeture de la lightbox : clic sur le fond sombre ou la croix
  document.getElementById('lightbox-overlay').addEventListener('click', function(e) {
    // On ferme si on clique sur le fond (overlay) ou sur le bouton .lightbox-close
    if (
      e.target.id === 'lightbox-overlay' ||
      e.target.classList.contains('lightbox-close')
    ) {
      document.getElementById('lightbox-overlay').style.display = 'none'; // Cache la lightbox
      document.body.style.overflow = ''; // Réactive le scroll de la page
    }
  });

  // 5. Navigation avec les flèches (précédente/suivante)
  document.addEventListener('click', function(e) {
    // Flèche gauche (précédent)
    if (e.target.closest('.lightbox-arrow-left')) {
      e.stopPropagation(); // Empêche d’autres clics sur le overlay
      photos = getAllPhotoLinks();
      if (currentIndex > 0) openLightbox(currentIndex - 1); // Va à la photo précédente
      else openLightbox(photos.length - 1); // Si on est à la première, boucle sur la dernière
    }
    // Flèche droite (suivant)
    if (e.target.closest('.lightbox-arrow-right')) {
      e.stopPropagation();
      photos = getAllPhotoLinks();
      if (currentIndex < photos.length - 1) openLightbox(currentIndex + 1); // Va à la photo suivante
      else openLightbox(0); // Si on est à la dernière, boucle sur la première
    }
  });

  // 6. Fermeture via la touche ESC et navigation clavier
  document.addEventListener('keydown', function(e) {
    if (e.key === "Escape") {
      // Ferme la lightbox si on appuie sur Echap
      document.getElementById('lightbox-overlay').style.display = 'none';
      document.body.style.overflow = '';
    }
    // Navigation avec les flèches du clavier (gauche/droite)
    if (document.getElementById('lightbox-overlay').style.display === 'flex') {
      if (e.key === "ArrowLeft") document.querySelector('.lightbox-arrow-left').click();
      if (e.key === "ArrowRight") document.querySelector('.lightbox-arrow-right').click();
    }
  });

});




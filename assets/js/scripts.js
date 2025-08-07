// ======== BURGER MENU (menu mobile responsive) ========

document.addEventListener('DOMContentLoaded', function() {
  // On attend que tout le DOM soit chargé pour ne pas avoir d’erreur de sélection
  const burger = document.querySelector('.burger');
  const menu = document.getElementById('main-menu');
  if (burger && menu) { // On vérifie que les deux éléments existent
    // --- Quand on clique sur le bouton burger ---
    burger.addEventListener('click', function() {
       // On bascule la classe .open sur le menu (ouvre/ferme le menu avec le CSS)
      const isOpen = menu.classList.toggle('open');
      // On indique au lecteur d’écran si le menu est ouvert (accessibilité)
      burger.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
      // On ajoute/enlève la classe .open sur le burger pour l’animer (croix, changement visuel)
      burger.classList.toggle('open', isOpen);
    });
    // --- Fermer le menu quand on clique sur un lien du menu ---
    menu.querySelectorAll('a').forEach(link => {
      link.addEventListener('click', () => {
        // Ferme le menu principal (enlève la classe .open)
        menu.classList.remove('open');
        burger.classList.remove('open');
        burger.setAttribute('aria-expanded', 'false');
      });
    });
  }
});


// ======== MODALE DE CONTACT (popup de formulaire) ========

document.addEventListener('DOMContentLoaded', function() {
  // === OUVERTURE DE LA MODALE ===
  document.body.addEventListener('click', function(e) {
    let target = e.target;
    // Si on clique sur un élément qui a la classe .open-contact-modal
    if (target.classList && target.classList.contains('open-contact-modal')) {
      e.preventDefault();    // Empêche le comportement par défaut du lien/bouton
      ouvrirModaleContact(); // Appelle la fonction pour ouvrir la modale
    }
    // Si on clique sur un lien <a> qui est dans un élément .open-contact-modal (ex : une icône dans un bouton)
    else if (
      target.tagName === 'A' &&
      target.parentElement &&
      target.parentElement.classList &&
      target.parentElement.classList.contains('open-contact-modal')
    ) {
      e.preventDefault();
      ouvrirModaleContact();
    }
  });
  // --- Fonction d'ouverture de la modale ---
  function ouvrirModaleContact() {
    const modal = document.getElementById('contact-modal-backdrop');
    if (modal) {
      modal.style.display = 'flex';
      document.body.style.overflow = 'hidden';
    }
  }
  // === FERMETURE DE LA MODALE VIA CROIX ===
  const closeBtn = document.getElementById('contact-modal-close');
  if (closeBtn) {
    closeBtn.addEventListener('click', function() {
      fermerModaleContact(); // Appelle la fonction pour fermer la modale
    });
  }
  // === FERMETURE EN CLIQUANT SUR LE BACKDROP ===
  const backdrop = document.getElementById('contact-modal-backdrop');
  if (backdrop) {
    backdrop.addEventListener('click', function(e) {
      // Si tu cliques exactement sur le fond sombre (et pas sur le contenu de la modale)
      if (e.target === this) {
        fermerModaleContact();
      }
    });
  }
  // --- Fonction de fermeture de la modale ---
  function fermerModaleContact() {
    const modal = document.getElementById('contact-modal-backdrop');
    if (modal) {
      modal.style.display = 'none';       // Cache la modale
      document.body.style.overflow = '';  // Réactive le scroll du fond
    }
  }
});

// ======== PRÉREMPLISSAGE AUTOMATIQUE DU CHAMP "RÉF. PHOTO" ========
jQuery(document).on('click', '.open-contact-modal', function(e) {
  e.preventDefault(); // Empêche le comportement standard du lien
  jQuery('#contact-modal-backdrop').fadeIn(200); // Affiche la modale avec une animation
  var reference = jQuery(this).data('reference'); // Récupère la donnée "reference" du bouton cliqué
  jQuery('#happyforms-25_single_line_text_8').val(reference); // Remplit automatiquement le champ Réf. Photo dans le formulaire
});

// ======== MINIATURES SUR LES FLÈCHES DE NAVIGATION (hover) ========

jQuery(function($) {
  $('.photo-nav-link').hover(function() { // Au survol de la flèche de navigation
    var thumb = $(this).data('thumb'); // On récupère l'URL de la miniature associée
    if (thumb) {
      $('.photo-nav-thumb-preview').html('<img src="'+thumb+'" alt="Miniature" style="max-width:80px;max-height:80px;border:1px solid #eee;">').fadeIn(100); // On affiche la vignette en la faisant apparaître en douceur
    }
  }, function() { // Quand la souris quitte la flèche
    $('.photo-nav-thumb-preview').fadeOut(80, function(){ $(this).empty(); });
  });
});

// ==============================
//  GRILLE PHOTOS : FILTRES + "CHARGER PLUS" (AJAX)
// ==============================

jQuery(function($){
  // Fonction utilitaire pour récupérer tous les filtres actifs(custom-select)
  function getFilters() {
    return {
      categorie: $('input[name="categorie"]').val(),
      format: $('input[name="format"]').val(),
      tri: $('input[name="tri"]').val()
    };
  }

  // Fonction principale pour charger ou recharger la grille de photos avec AJAX
    window.refreshPhotos = function(page, append = false) {
    $('#load-more-photos').data('page', page).show(); // On note la page demandée
    $.ajax({
      type: 'POST', // Envoi POST (données cachées)
      url: ajaxurl, // URL AJAX générée par WP
      data: Object.assign({
        action: 'motaphoto_filter_photos', // Action côté PHP à appeler
        page: page // N° de page à charger
      }, getFilters()), // On fusionne avec les filtres actifs
      beforeSend: function() {
        if (!append) {
          $('#photo-grid').html('<p>Chargement...</p>'); // Affiche un message pendant le chargement (si on recharge tout)
        } else {
          $('#load-more-photos').prop('disabled', true).text('Chargement...'); // Désactive le bouton temporairement (si on ajoute des photos à la suite)
        }
      },
      success: function(response) { 
        // On reçoit le HTML à insérer (liste des blocs photo)
        let $newItems = $('<div>' + response + '</div>').find('.photo-block');
        if (!append) {
          // Si c'est un rafraîchissement complet
          $('#photo-grid').html($newItems);
          if ($newItems.length < 8) $('#load-more-photos').hide();
          else $('#load-more-photos').show().data('page', 1).prop('disabled', false).text('Charger plus');
        } else {
          // Si on ajoute des photos (scroll infini ou bouton “Charger plus”)
          if ($newItems.length > 0) {
            $('#photo-grid').append($newItems);
            $('#load-more-photos').data('page', page).prop('disabled', false).text('Charger plus');
            if ($newItems.length < 8) $('#load-more-photos').hide();
          } else {
            $('#load-more-photos').hide();
          }
        }
      }
    });
  }

  // Quand on clique sur un filtre (custom-select), on recharge la grille de photos
  $('.custom-select-option').on('mousedown', function() {
    // Après la sélection, attend une "boucle" pour que le DOM soit bien à jour (important)
    setTimeout(function() {
      refreshPhotos(1, false);
    }, 10); // On attend que la sélection soit bien prise en compte dans le DOM
  });

  // Quand on clique sur "Charger plus", on charge la page suivante de photos
  $('#load-more-photos').on('click', function(e) {
    e.preventDefault();
    let page = $(this).data('page') || 1;
    let nextPage = page + 1;
    refreshPhotos(nextPage, true); // On demande à ajouter la suite des photos
  });

  // Si au chargement initial il y a moins de 8 photos, on cache le bouton “Charger plus”
  if ($('#photo-grid .photo-block').length < 8) {
    $('#load-more-photos').hide();
  }
});


// ======== REMISE À ZÉRO DES FILTRES (custom-selec) AU CHARGEMENT DE LA PAGE ========
document.addEventListener('DOMContentLoaded', function() {
  document.querySelectorAll('.custom-select').forEach(select => {
    // Réinitialise l’étiquette visible
    let selected = select.querySelector('.custom-select-selected');
    if (selected) selected.textContent = selected.dataset.default || selected.textContent;
    // Vide la valeur cachée du filtre
    let input = select.querySelector('input[type="hidden"]');
    if (input) input.value = '';
    // Enlève la sélection visuelle sur toutes les options du dropdown
    select.querySelectorAll('.custom-select-option').forEach(opt => opt.classList.remove('selected'));
  });
  
});


// === JS custom-select (menus déroulants personnalisés pour les filtres)
document.querySelectorAll('.custom-select').forEach(select => {
  // Ouvre ou ferme le menu déroulant quand on clique sur l'élément visible (étiquette)
  select.querySelector('.custom-select-selected').addEventListener('click', function(e) {
    e.stopPropagation();
    if(select.classList.contains('open')) {
      // Si le menu est déjà ouvert : on le ferme
      select.classList.remove('open','active');
    } else {
      // Sinon : on ferme les autres menus ouverts et on ouvre celui-ci
      document.querySelectorAll('.custom-select').forEach(s => s.classList.remove('open','active'));
      select.classList.add('open','active');
    }
  });

  // Quand on clique sur une option du menu déroulant
  select.querySelectorAll('.custom-select-option').forEach(option => {
    option.addEventListener('mousedown', function(e) {
      e.stopPropagation();// On évite de refermer le menu tout de suite
      // On retire l'état sélectionné de toutes les options du menu
      select.querySelectorAll('.custom-select-option').forEach(opt => opt.classList.remove('selected'));
      // On ajoute l'état sélectionné à l'option cliquée (mise en surbrillance)
      this.classList.add('selected');
      // On met à jour l'étiquette visible (texte affiché dans le select)
      select.querySelector('.custom-select-selected').textContent = this.textContent.toUpperCase();
      // On met à jour l'input caché associé (pour le JS/AJAX)
      select.querySelector('input[type="hidden"]').value = this.dataset.value;
      // On ferme le menu après la sélection
      select.classList.remove('open','active');

      // On recharge la grille de photos via AJAX (filtrage dynamique)
      if (typeof refreshPhotos === "function") refreshPhotos(1, false);
    });
  });

  // Ferme le menu si on clique n'importe où ailleurs sur la page
  document.addEventListener('click', function(e) {
    if (!select.contains(e.target)) select.classList.remove('open','active');
  });

  // --- RESET sur le "gap" du haut de la dropdown ---
  select.querySelector('.custom-select-dropdown').addEventListener('click', function(e) {
    // Gestion du "reset" si on clique sur le haut du menu déroulant (en dehors des options)
    const dropdownRect = this.getBoundingClientRect();
    const clickY = e.clientY - dropdownRect.top;
    const firstOption = this.querySelector('.custom-select-option');
    // Si le clic est en haut, sur la "marge", on considère que c'est une demande de réinitialisation
    if (
      !e.target.classList.contains('custom-select-option') &&
      clickY < (firstOption ? firstOption.offsetTop : 50)
    ) {
      // On remet le label d'origine (ex : "CATEGORIES", "FORMATS" ou "TRIER PAR")
      const type = select.getAttribute('data-type');
      let label = 'CATEGORIES';
      if (type === 'format') label = 'FORMATS';
      if (type === 'tri') label = 'TRIER PAR';

      select.querySelector('.custom-select-selected').textContent = label;
      // On enlève l'état sélectionné sur toutes les options
      select.querySelectorAll('.custom-select-option').forEach(opt => opt.classList.remove('selected'));
      // On vide l'input caché (plus de filtre actif)
      select.querySelector('input[type="hidden"]').value = '';
      // On ferme le menu
      select.classList.remove('open', 'active');

      // On recharge la grille de photos via AJAX (tous les filtres remis à zéro)
      if (typeof refreshPhotos === "function") refreshPhotos(1, false);
    }
  });
});


   


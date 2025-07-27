// ========== BURGER MENU ==========

document.addEventListener('DOMContentLoaded', function() {
  const burger = document.querySelector('.burger');
  const menu = document.getElementById('main-menu');
  if (burger && menu) {
    burger.addEventListener('click', function() {
      const isOpen = menu.classList.toggle('open');
      burger.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
      burger.classList.toggle('open', isOpen);
    });
    // Fermer le menu en cliquant sur un lien
    menu.querySelectorAll('a').forEach(link => {
      link.addEventListener('click', () => {
        menu.classList.remove('open');
        burger.classList.remove('open');
        burger.setAttribute('aria-expanded', 'false');
      });
    });
  }
});


// ========== MODALE CONTACT ==========

document.addEventListener('DOMContentLoaded', function() {
  // === OUVERTURE DE LA MODALE ===
  document.body.addEventListener('click', function(e) {
    let target = e.target;
    if (target.classList && target.classList.contains('open-contact-modal')) {
      e.preventDefault();
      ouvrirModaleContact();
    }
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
      fermerModaleContact();
    });
  }
  // === FERMETURE EN CLIQUANT SUR LE BACKDROP ===
  const backdrop = document.getElementById('contact-modal-backdrop');
  if (backdrop) {
    backdrop.addEventListener('click', function(e) {
      if (e.target === this) {
        fermerModaleContact();
      }
    });
  }
  function fermerModaleContact() {
    const modal = document.getElementById('contact-modal-backdrop');
    if (modal) {
      modal.style.display = 'none';
      document.body.style.overflow = '';
    }
  }
});

// Préremplir champ Réf. Photo dans la modale
jQuery(document).on('click', '.open-contact-modal', function(e) {
  e.preventDefault();
  jQuery('#contact-modal-backdrop').fadeIn(200);
  var reference = jQuery(this).data('reference');
  jQuery('#happyforms-25_single_line_text_8').val(reference);
});

// ========== MINIATURES NAVIGATION (flèches) ==========

jQuery(function($) {
  $('.photo-nav-link').hover(function() {
    var thumb = $(this).data('thumb');
    if (thumb) {
      $('.photo-nav-thumb-preview').html('<img src="'+thumb+'" alt="Miniature" style="max-width:80px;max-height:80px;border:1px solid #eee;">').fadeIn(100);
    }
  }, function() {
    $('.photo-nav-thumb-preview').fadeOut(80, function(){ $(this).empty(); });
  });
});

// ==============================
//  GRILLE PHOTOS : FILTRES + "CHARGER PLUS" (AJAX)
// ==============================

jQuery(function($){

  // -- Helper pour récupérer les valeurs des filtres (custom-select)
  function getFilters() {
    return {
      categorie: $('input[name="categorie"]').val(),
      format: $('input[name="format"]').val(),
      tri: $('input[name="tri"]').val()
    };
  }

  // -- Rafraîchir la grille AJAX avec les filtres actifs (et page courante)
  function refreshPhotos(page, append = false) {
    $('#load-more-photos').data('page', page).show();
    $.ajax({
      type: 'POST',
      url: ajaxurl,
      data: Object.assign({
        action: 'motaphoto_filter_photos',
        page: page
      }, getFilters()),
      beforeSend: function() {
        if (!append) {
          $('#photo-grid').html('<p>Chargement...</p>');
        } else {
          $('#load-more-photos').prop('disabled', true).text('Chargement...');
        }
      },
      success: function(response) {
        let $newItems = $('<div>' + response + '</div>').find('.photo-block');
        if (!append) {
          $('#photo-grid').html($newItems);
          if ($newItems.length < 8) $('#load-more-photos').hide();
          else $('#load-more-photos').show().data('page', 1).prop('disabled', false).text('Charger plus');
        } else {
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

  // -- FILTRES : changement d’une option custom-select
  $('.custom-select-option').on('mousedown', function() {
    // Après la sélection, attend une "boucle" pour que le DOM soit bien à jour (important)
    setTimeout(function() {
      refreshPhotos(1, false);
    }, 10);
  });

  // -- BOUTON "CHARGER PLUS" (avec filtres actifs)
  $('#load-more-photos').on('click', function(e) {
    e.preventDefault();
    let page = $(this).data('page') || 1;
    let nextPage = page + 1;
    refreshPhotos(nextPage, true);
  });

  // -- INIT : cache le bouton si moins de 8 photos dès le départ
  if ($('#photo-grid .photo-block').length < 8) {
    $('#load-more-photos').hide();
  }
});


// -- Remise à zéro des custom-select au chargement de la page
document.addEventListener('DOMContentLoaded', function() {
  document.querySelectorAll('.custom-select').forEach(select => {
    // Reset visuel
    let selected = select.querySelector('.custom-select-selected');
    if (selected) selected.textContent = selected.dataset.default || selected.textContent;
    // Reset hidden
    let input = select.querySelector('input[type="hidden"]');
    if (input) input.value = '';
    // Reset selected dans dropdown
    select.querySelectorAll('.custom-select-option').forEach(opt => opt.classList.remove('selected'));
  });
  // Recharge la grille (optionnel)
  // refreshPhotos(1, false);
});


// === JS custom-select
document.querySelectorAll('.custom-select').forEach(select => {
  // Gère l'ouverture/fermeture uniquement sur le click du selected (pas la dropdown)
  select.querySelector('.custom-select-selected').addEventListener('click', function(e) {
    e.stopPropagation();
    if(select.classList.contains('open')) {
      select.classList.remove('open','active');
    } else {
      // Ferme tous les autres
      document.querySelectorAll('.custom-select').forEach(s => s.classList.remove('open','active'));
      select.classList.add('open','active');
    }
  });

  // Option sélectionnée
  select.querySelectorAll('.custom-select-option').forEach(option => {
    option.addEventListener('mousedown', function(e) {
      e.stopPropagation();
      select.querySelectorAll('.custom-select-option').forEach(opt => opt.classList.remove('selected'));
      this.classList.add('selected');
      select.querySelector('.custom-select-selected').textContent = this.textContent.toUpperCase();
      select.querySelector('input[type="hidden"]').value = this.dataset.value;
      select.classList.remove('open','active'); // Ferme
    });
  });

  // Ferme le select si on clique ailleurs
  document.addEventListener('click', function(e) {
    if (!select.contains(e.target)) select.classList.remove('open','active');
  });
});






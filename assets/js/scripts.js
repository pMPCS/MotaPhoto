document.addEventListener('DOMContentLoaded', function() {
  const burger = document.querySelector('.burger');
  const menu = document.getElementById('main-menu');

  if (burger && menu) {
    burger.addEventListener('click', function() {
      const isOpen = menu.classList.toggle('open');
      burger.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
      // Ajoute ou retire la classe "open" sur le burger
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





document.addEventListener('DOMContentLoaded', function() {

  // === OUVERTURE DE LA MODALE ===
  document.body.addEventListener('click', function(e) {
    // Vérifie si on clique sur <li class="open-contact-modal"> ou sur un <a> dedans
    let target = e.target;

    // Cas 1 : clic sur le <li>
    if (target.classList && target.classList.contains('open-contact-modal')) {
      e.preventDefault();
      console.log('Click sur le <li> Contact (open-contact-modal)');
      ouvrirModaleContact();
    }
    // Cas 2 : clic sur le <a> à l'intérieur du <li>
    else if (
      target.tagName === 'A' &&
      target.parentElement &&
      target.parentElement.classList &&
      target.parentElement.classList.contains('open-contact-modal')
    ) {
      e.preventDefault();
      console.log('Click sur le <a> Contact dans <li class="open-contact-modal">');
      ouvrirModaleContact();
    }
  });

  // Fonction d'ouverture de la modale
  function ouvrirModaleContact() {
    const modal = document.getElementById('contact-modal-backdrop');
    if (modal) {
      modal.style.display = 'flex';
      document.body.style.overflow = 'hidden';
      console.log('Modale affichée');
    } else {
      console.log('Modale introuvable dans le DOM');
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

  // Fonction de fermeture de la modale
  function fermerModaleContact() {
    const modal = document.getElementById('contact-modal-backdrop');
    if (modal) {
      modal.style.display = 'none';
      document.body.style.overflow = '';
      console.log('Modale cachée');
    }
  }

});




 
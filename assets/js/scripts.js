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

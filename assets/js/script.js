// MENU BURGER

(function(){
  const body    = document.body;
  const burger  = document.querySelector('.menu-toggle');
  const overlay = document.getElementById('nm-menu-overlay');

  if(!burger || !overlay) return;

  function openMenu(){
    body.classList.add('menu-open', 'fade-in');
    burger.setAttribute('aria-expanded', 'true');
    overlay.hidden = false;
    overlay.setAttribute('aria-hidden', 'false');
    body.style.overflow = 'hidden';
  }
  function closeMenu(){
    body.classList.remove('menu-open', 'fade-in');
    burger.setAttribute('aria-expanded', 'false');
    overlay.hidden = true;
    overlay.setAttribute('aria-hidden', 'true');
    body.style.overflow = '';
  }
  function toggleMenu(){
    body.classList.contains('menu-open') ? closeMenu() : openMenu();
  }

  burger.addEventListener('click', toggleMenu);
  overlay.querySelectorAll('a').forEach(a => a.addEventListener('click', closeMenu));

// Fermer si on repasse en tablette/desktop
  window.addEventListener('resize', () => {
    if (window.innerWidth > 720) closeMenu();
  });
})();


// MODALE

document.addEventListener('DOMContentLoaded', function () {
  const modal    = document.getElementById('contactModal');
  const closeBtn = modal ? modal.querySelector('.close') : null;

// Ouvre la modale depuis tous les liens "Contact" (desktop et burger)
if (modal) {
  document.querySelectorAll('li.open-contact > a, a.open-contact').forEach(link => {
    link.addEventListener('click', e => {
      e.preventDefault();
      modal.style.display = 'block';
      document.body.style.overflow = 'hidden';
    });
  });
}

  function closeModal() {
    modal.style.display = 'none';
    document.body.style.overflow = '';
  }

  if (closeBtn) {
    closeBtn.addEventListener('click', closeModal);
  }

  // Clic en dehors de la fenêtre
  if (modal) {
    modal.addEventListener('click', function (e) {
      if (e.target === modal) closeModal();
    });
  }
});

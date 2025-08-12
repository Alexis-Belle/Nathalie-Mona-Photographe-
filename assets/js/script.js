(function(){
  const body    = document.body;
  const burger  = document.querySelector('.menu-toggle');
  const overlay = document.getElementById('nm-menu-overlay');

  if(!burger || !overlay) return;

  function openMenu(){
    body.classList.add('menu-open');
    burger.setAttribute('aria-expanded', 'true');
    overlay.hidden = false;
    overlay.setAttribute('aria-hidden', 'false');
    body.style.overflow = 'hidden';
  }
  function closeMenu(){
    body.classList.remove('menu-open');
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

// MENU BURGER

(() => {
  const body    = document.body;
  const burger  = document.querySelector('.menu-toggle');
  const overlay = document.getElementById('nm-menu-overlay');

  if (!burger || !overlay) return; // stop si pas d'éléments

  // Ouvre le menu
  const openMenu = () => {
    body.classList.add('menu-open', 'fade-in');
    burger.setAttribute('aria-expanded', 'true');
    overlay.setAttribute('aria-hidden', 'false');
    body.style.overflow = 'hidden';
  };

  // Ferme le menu
  const closeMenu = () => {
    body.classList.remove('menu-open', 'fade-in');
    burger.setAttribute('aria-expanded', 'false');
    overlay.setAttribute('aria-hidden', 'true');
    body.style.overflow = '';
  };

  // Alterne entre ouvert et fermé
  const toggleMenu = () =>
    body.classList.contains('menu-open') ? closeMenu() : openMenu();

  // Clic sur le burger
  burger.addEventListener('click', toggleMenu);

  // Ferme en cliquant sur un lien du menu
  overlay.querySelectorAll('a').forEach(a => a.addEventListener('click', closeMenu));

  // Ferme automatiquement si retour en desktop
  window.addEventListener('resize', () => {
    if (window.innerWidth > 720) closeMenu();
  });
})();


// MODALE

jQuery(document).ready(($) => {
  const $modal    = $('#contactModal');
  const $refInput = $modal.find('input[name="your-subject"]');

  // Ouvre la modale, pré-remplit si ref fournie
  const openModal = (ref = '') => {
    $modal.show();
    $('body').css('overflow', 'hidden');
    if ($refInput.length && ref) $refInput.val(ref);
  };

  // Ferme la modale
  const closeModal = () => {
    $modal.hide();
    $('body').css('overflow', '');
  };

  // Ouvre depuis liens "Contact"
  $('li.open-contact > a, a.open-contact').on('click', (e) => {
    e.preventDefault();
    openModal();
  });

  // Ouvre depuis bouton avec data-ref
  $('.js-open-contact').on('click', function(e) {
    e.preventDefault();
    openModal($(this).data('ref'));
  });

  // Fermeture avec bouton X
  $modal.find('.close').on('click', closeModal);

  // Fermeture en cliquant hors contenu
  $modal.on('click', (e) => { if (e.target === $modal[0]) closeModal(); });
});

// PHOTO DETAIL (HOVER MINIATURES)

document.addEventListener('DOMContentLoaded', () => {
  const nav = document.querySelector('.single-photo__nav');
  if (!nav) return; // stop si pas de navigation

  const prevLnk = nav.querySelector('.nav-prev');
  const nextLnk = nav.querySelector('.nav-next');
  const prevImg = nav.querySelector('.preview-prev');
  const nextImg = nav.querySelector('.preview-next');

  // Montre miniature précédente
  const showPrev = () => {
    prevImg?.classList.add('active');
    nextImg?.classList.remove('active');
  };

  // Montre miniature suivante
  const showNext = () => {
    nextImg?.classList.add('active');
    prevImg?.classList.remove('active');
  };

  // Gestion des hover/focus
  prevLnk?.addEventListener('mouseenter', showPrev);
  nextLnk?.addEventListener('mouseenter', showNext);
  prevLnk?.addEventListener('focusin', showPrev);
  nextLnk?.addEventListener('focusin', showNext);
});

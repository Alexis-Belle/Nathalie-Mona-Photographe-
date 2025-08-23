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

jQuery(document).ready(function($) {
  const $modal    = $('#contactModal');
  const $refInput = $modal.find('input[name="your-subject"]');

  // Ouvre la modale depuis le header
  $('li.open-contact > a, a.open-contact').on('click', function(e) {
    e.preventDefault();
    $modal.show();
    $('body').css('overflow', 'hidden');
  });

  // Ouvre la modale depuis bouton avec data-ref
  $('.js-open-contact').on('click', function(e) {
    e.preventDefault();
    $modal.show();
    $('body').css('overflow', 'hidden');

    // récupère la valeur data-ref du bouton et préremplit
    const ref = $(this).data('ref');
    if ($refInput.length && ref) {
      $refInput.val(ref);
    }
  });

  // Fermeture modale
  $modal.find('.close').on('click', function() {
    $modal.hide();
    $('body').css('overflow', '');
  });

  // Clic en dehors du contenu
  $modal.on('click', function(e) {
    if (e.target === this) {
      $modal.hide();
      $('body').css('overflow', '');
    }
  });
});

// PHOTO DETAIL

// Gestion des flèches dans le détail des photos
document.addEventListener('DOMContentLoaded', () => {
  const nav = document.querySelector('.single-photo__nav');
  if (!nav) return;

  const prevLnk = nav.querySelector('.nav-prev');
  const nextLnk = nav.querySelector('.nav-next');
  const prevImg = nav.querySelector('.preview-prev');
  const nextImg = nav.querySelector('.preview-next');

  const showPrev = () => {
    if (prevImg) prevImg.classList.add('active');
    if (nextImg) nextImg.classList.remove('active');
  };

  const showNext = () => {
    if (nextImg) nextImg.classList.add('active');
    if (prevImg) prevImg.classList.remove('active');
  };

  // Hover / focus
  prevLnk?.addEventListener('mouseenter', showPrev);
  nextLnk?.addEventListener('mouseenter', showNext);
  prevLnk?.addEventListener('focusin',   showPrev);
  nextLnk?.addEventListener('focusin',   showNext);
});




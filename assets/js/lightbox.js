(() => {
  const lb = document.getElementById('lb'); 
  if (!lb) return; // stoppe si pas de lightbox

  // Récupération des éléments
  const overlay = lb.querySelector('.lb__overlay');
  const imgEl   = lb.querySelector('.lb__img');
  const refEl   = lb.querySelector('.lb__ref');
  const catEl   = lb.querySelector('.lb__cat');
  const btnClose= lb.querySelector('.lb__btn--close');

  let items = []; // liste des images
  let index = 0;  // image affichée

  // Récupère toutes les images cliquables
  function collect() {
    const triggers = Array.from(document.querySelectorAll('[data-lightbox]'));
    items = triggers.map(el => ({
      el,
      src: el.getAttribute('data-src') || el.getAttribute('href') || el.getAttribute('src'),
      title: el.getAttribute('data-title') || '',
      ref: el.getAttribute('data-ref') || '',
      cat: el.getAttribute('data-cat') || ''
    })).filter(i => !!i.src);
  }

  // Ouvre la lightbox
  function open(i) {
    index = i;
    update();
    lb.classList.remove('lb--hidden');
    document.body.style.overflow = 'hidden';
  }

  // Ferme la lightbox
  function close() {
    lb.classList.add('lb--hidden');
    document.body.style.overflow = '';
  }

  // Met à jour image + infos
  function update() {
    const it = items[index];
    if (!it) return;
    imgEl.src = it.src;
    if (refEl) refEl.textContent = it.ref;
    if (catEl) catEl.textContent = it.cat;
  }

  // Navigation
  function prev() { index = (index - 1 + items.length) % items.length; update(); }
  function next() { index = (index + 1) % items.length; update(); }

  // Ouvre au clic sur une miniature
  document.addEventListener('click', (e) => {
    const el = e.target.closest('[data-lightbox]');
    if (!el) return;
    e.preventDefault();
    collect();
    const i = items.findIndex(x => x.el === el);
    if (i >= 0) open(i);
  });

  // Navigation interne (flèches, close)
  lb.addEventListener('click', (e) => {
    if (e.target.closest('.lb__arrow--prev')) { e.preventDefault(); prev(); }
    else if (e.target.closest('.lb__arrow--next')) { e.preventDefault(); next(); }
    else if (e.target.closest('[data-close]')) { e.preventDefault(); close(); }
  });

  // Overlay et bouton
  overlay.addEventListener('click', close);
  btnClose?.addEventListener('click', close);

  // Navigation clavier
  document.addEventListener('keydown', (e) => {
    if (lb.classList.contains('lb--hidden')) return;
    if (e.key === 'Escape') close();
    if (e.key === 'ArrowLeft') prev();
    if (e.key === 'ArrowRight') next();
  });

  collect(); // init
})();

// GESTION AJAX PHOTOS

jQuery(function($){
  let page = 2; // La première page (1) est déjà affichée en PHP

  // Récupère les filtres actifs
  function getFilters() {
    return {
      category: $('#filter-category').val() || '',
      format:   $('#filter-format').val()   || '',
      order:    $('#filter-order').val()    || 'date_desc',
    };
  }

  // BOUTON "CHARGER PLUS"

  $('#load-more').on('click', function(){
    $.post(NM_AJAX.url, {
      action: 'nm_get_photos',
      nonce:  NM_AJAX.nonce,
      page:   page,
      ...getFilters()
    }, function(res){
      if (!res || !res.success) return; // Stop si erreur

      const html = res.data.html || '';
      $('#photo-grid').append(html); // Ajoute les nouvelles photos

      // Gère l'affichage du bouton
      if (res.data.hasMore) {
        page = res.data.nextPage;
        $('#load-more').show();
      } else {
        $('#load-more').hide();
      }
    });
  });

  // FILTRES (AU CHANGEMENT)

  $('#photo-filters').on('change', 'input[type=hidden]', function(){
    $.post(NM_AJAX.url, {
      action: 'nm_get_photos',
      nonce:  NM_AJAX.nonce,
      page:   1,
      ...getFilters()
    }, function(res){
      if (!res || !res.success) return;

      const html = res.data.html || '';
      $('#photo-grid').html(html); // Remplace les photos

      if (res.data.hasMore) {
        page = res.data.nextPage;
        $('#load-more').show();
      } else {
        $('#load-more').hide();
      }
    });
  });
});


// CUSTOM SELECTS <UL>

(function initCustomFilters($){
  $('.filter-list').each(function(){
    const $list = $(this);              // Liste <ul>
    const targetSel = $list.data('target'); 
    const $hidden   = $(targetSel);     // Input hidden lié

    const $items = $list.find('.filter-item');
    const $label = $items.first();      // Premier <li> = label

    $label.addClass('is-label');        // Ajoute la classe label
    $list.removeClass('is-open');       // Ferme la liste par défaut

    // Ouvrir/fermer la liste
    $label.on('click', function(e){
      e.preventDefault();
      $list.toggleClass('is-open');
    });

    // Sélection d'une option
    $items.not($label).on('click', function(e){
      e.preventDefault();
      const $opt = $(this);
      const val  = $opt.data('value') ?? '';
      const txt  = $.trim($opt.text());

      $items.removeClass('is-active');
      $opt.addClass('is-active');

      $label.text(txt).attr('data-value', val); // Affiche le choix
      if ($hidden.length) $hidden.val(val).trigger('change'); // MAJ input
      $list.removeClass('is-open');
    });
  });

  // Fermer en cliquant hors du composant
  $(document).on('click', function(e){
    if ($(e.target).closest('.filter-list').length === 0){
      $('.filter-list').removeClass('is-open');
    }
  });
})(jQuery);

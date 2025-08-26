jQuery(function($){
  let page = 2; // la page 1 est déjà rendue côté PHP

  function getFilters() {
    return {
      category: $('#filter-category').val() || '',
      format:   $('#filter-format').val()   || '',
      order:    $('#filter-order').val()    || 'date_desc',
    };
  }

  // Charger plus
  $('#load-more').on('click', function(){
    $.post(NM_AJAX.url, {
      action: 'nm_get_photos',
      nonce:  NM_AJAX.nonce,
      page:   page,
      ...getFilters()
    }, function(res){
      if (!res || !res.success) return;

      const html = res.data.html || '';
      $('#photo-grid').append(html);

      if (res.data.hasMore) {
        page = res.data.nextPage;
        $('#load-more').show();
      } else {
        $('#load-more').hide();
      }
    });
  });

  // Changement de filtres (inputs hidden mis à jour par les <li>)
  $('#photo-filters').on('change', 'input[type=hidden]', function(){
    $.post(NM_AJAX.url, {
      action: 'nm_get_photos',
      nonce:  NM_AJAX.nonce,
      page:   1,
      ...getFilters()
    }, function(res){
      if (!res || !res.success) return;

      const html = res.data.html || '';
      $('#photo-grid').html(html);

      if (res.data.hasMore) {
        page = res.data.nextPage;
        $('#load-more').show();
      } else {
        $('#load-more').hide();
      }
    });
  });
});

// Custom selects en <ul>
(function initCustomFilters($){
  $('.filter-list').each(function(){
    const $list = $(this);
    const targetSel = $list.data('target');
    const $hidden   = $(targetSel);

    const $items = $list.find('.filter-item');
    const $label = $items.first();      // 1er li = label

    // s'assure que le label a la class
    $label.addClass('is-label');

    // ferme par défaut
    $list.removeClass('is-open');

    // ouvrir/fermer au clic sur le label
    $label.on('click', function(e){
      e.preventDefault();
      $list.toggleClass('is-open');
    });

    // choisir une option
    $items.not($label).on('click', function(e){
      e.preventDefault();
      const $opt = $(this);
      const val  = $opt.data('value') ?? '';
      const txt  = $.trim($opt.text());

      // visuel actif
      $items.removeClass('is-active');
      $opt.addClass('is-active');

      // met à jour le label (affiche le choix)
      $label.text(txt).attr('data-value', val);

      // met à jour l'input caché + déclenche change
      if ($hidden.length){
        $hidden.val(val).trigger('change');
      }

      // refermer
      $list.removeClass('is-open');
    });
  });

  // ferme si on clique hors du composant
  $(document).on('click', function(e){
    if ($(e.target).closest('.filter-list').length === 0){
      $('.filter-list').removeClass('is-open');
    }
  });
})(jQuery);

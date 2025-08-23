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

  // Changement de filtres
  $('#photo-filters').on('change', 'select', function(){
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

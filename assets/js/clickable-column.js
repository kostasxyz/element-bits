(function($) {
  $(document).on( 'click', 'body:not(.elementor-editor-active) .eb-clickable-column', function(e) {
    var wrapper = $(this);
    var url = wrapper.data('eb-col-clickable-url');

    if (url) {
      if ( $(e.target).filter( 'a, a *, .no-link, .no-link *' ).length ) {
        return true;
      }

      // Handle elementor actions
      if (url.match( '^%23elementor-action')) {

        var hash = url;
        var hash = decodeURIComponent(hash);

        // if is Popup
        if ( hash.includes( "elementor-action:action=popup:open" ) || hash.includes( "elementor-action:action=lightbox" ) ) {
          if ( 0 === wrapper.find( '.eb-col-clickable-open-dynamic' ).length ) {
            wrapper.append( '<a class="eb-col-clickable-open-dynamic" style="display:none!important;"href="'+url+'">eb</a>' );
          }

          wrapper.find('.eb-col-clickable-open-dynamic').click();

          return true;
        }

        return true;
      }

      // smooth scroll
      if (url.match( "^#" )) {
        var hash = url;

        $('html, body').animate( {
          scrollTop: $(hash).offset().top
        }, 800, function() {
          window.location.hash = hash;
        });

        return true;
      }

      window.open( url, wrapper.data('eb-col-clickable-target') );
      return false;
    }
  });
})(jQuery);

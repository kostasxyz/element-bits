;(function($){

  var ebWpmlLangSwitch = function( $scope, $ ) {
    var openBtns = $scope.find('.ntrjs-eb-lang-switch-handle');
    console.log(openBtns)

    // instanciate new modal
    var modal = new tingle.modal({
      footer: false,
      stickyFooter: false,
      closeMethods: ['overlay', 'button', 'escape'],
      cssClass: ['eb-wpml-lang-switch-modal', 'eb-tingle-modal'],
      onOpen: function() {},
      onClose: function() {},
      beforeClose: function() {
        return true; // close the modal
    }
  });

  for(var i = 0; i < openBtns.length; i++) {
    openBtns[i].addEventListener('click', function(evt) {
      console.log(123)
      evt.stopPropagation();
      evt.preventDefault();

      const content = document.querySelector('[data-eb-modal="' + this.dataset.ebEid + '"]').innerHTML;

      modal.setContent(content);
      modal.open();
    });
  }
  }

  // Make sure you run this code under Elementor.
  $(window).on( 'elementor/frontend/init', function() {
    elementorFrontend.hooks.addAction( 'frontend/element_ready/eb-wpml-lang-switch.default', ebWpmlLangSwitch );
  } );
})(jQuery);

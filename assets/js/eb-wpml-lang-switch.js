;(function($){

  var ebWpmlLangSwitch = function( $scope, $ ) {
    var openBtns = $scope.find('.ebjs-lang-switch-modal-open');
    var closeBtns = $scope.find('.ebjs-lang-switch-modal-close');
    var modal = $scope.find('.ebjs-modal-container');

    modal.on('click', function(el) {
      modal.removeClass('eb-modal-container--open');
    });

    openBtns.on('click', function() {
      modal.addClass('eb-modal-container--open');
    });

    closeBtns.on('click', function() {
      modal.removeClass('eb-modal-container--open');
    });
  }

  // Make sure you run this code under Elementor.
  $(window).on( 'elementor/frontend/init', function() {
    elementorFrontend.hooks.addAction( 'frontend/element_ready/eb-wpml-lang-switch.default', ebWpmlLangSwitch );
  } );
})(jQuery);

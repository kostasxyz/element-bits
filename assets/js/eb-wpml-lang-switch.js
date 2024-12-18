;(function($) {
  var ebWpmlLangSwitch = function($scope, $) {
    var openBtns = $scope.find('.ebjs-lang-switch-modal-open');
    var closeBtns = $scope.find('.ebjs-lang-switch-modal-close');
    var modal = $scope.find('.ebjs-modal-container');
    var modalContent = $scope.find('.ebjs-modal-content');

    // Helper function to toggle modal
    function toggleModal(show) {
      if (show) {
        modal.addClass('eb-modal-container--open');
        // Set focus to close button when modal opens
        closeBtns.first().focus();
        // Prevent body scroll when modal is open
        $('body').css('overflow', 'hidden');
      } else {
        modal.removeClass('eb-modal-container--open');
        // Return focus to the opener button
        openBtns.first().focus();
        // Restore body scroll
        $('body').css('overflow', '');
      }
    }

    // Close modal when clicking outside content
    modal.on('click', function(e) {
      if (!$(e.target).closest(modalContent).length) {
        toggleModal(false);
      }
    });

    // Open modal
    openBtns.on('click', function(e) {
      e.preventDefault();
      toggleModal(true);
    });

    // Close modal
    closeBtns.on('click', function(e) {
      e.preventDefault();
      toggleModal(false);
    });

    // Handle ESC key
    $(document).on('keydown', function(e) {
      if (e.key === 'Escape' && modal.hasClass('eb-modal-container--open')) {
        toggleModal(false);
      }
    });

    // Cleanup on widget destroy
    return function() {
      $(document).off('keydown');
      openBtns.off('click');
      closeBtns.off('click');
      modal.off('click');
    };
  };

  // Initialize widget
  $(window).on('elementor/frontend/init', function() {
    elementorFrontend.hooks.addAction('frontend/element_ready/eb-wpml-lang-switch.default', ebWpmlLangSwitch);
  });
})(jQuery);

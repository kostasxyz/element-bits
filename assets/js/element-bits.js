(function($){
  //-----------------------------------------------------
  // Menu icon

  $(document).on( 'click', '.ebjs-menu-icon-toggle', function(e) {
    e.preventDefault();
    $('body').toggleClass('eb-menu-icon-btn--toggled');
    $('body').toggleClass('eb-menu-icon-btn--active');
  });

  $(document).on('elementor/popup/hide', ( event, id, instance ) => {
    if($(instance.$element.find('.eb-accordion-wp-menu-list'))) {
      $('body').removeClass('eb-menu-icon-btn--toggled');
      $('body').removeClass('eb-menu-icon-btn--active');
    }
  });

})(jQuery);

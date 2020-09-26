(function($){
    //-----------------------------------------------------
    // Menu icon

  $('body').on( 'click', '.ebjs-menu-icon-toggle', function(e) {
    e.preventDefault();
    // deprecated css class
    $('body').toggleClass('eb-menu-icon-btn--toggled');
    $('body').toggleClass('eb-menu-icon-btn--active');
  });

})(jQuery);

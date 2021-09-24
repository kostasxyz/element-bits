(function($){
  //-----------------------------------------------------
  // Menu icon

  $(document).on( 'click', '.ebjs-menu-icon-toggle', function(e) {
    e.preventDefault();
    // deprecated css class
    $('body').toggleClass('eb-menu-icon-btn--toggled');
    $('body').toggleClass('eb-menu-icon-btn--active');
  });

  //-----------------------------------------------------
  // Close popuop with nav links with hashtags
  $(document).on('click','.ntr-nav-item:not(.menu-item-has-children ) .ntr-nav-link-anchor', function(event){
    elementorProFrontend.modules.popup.closePopup( {}, event);
    $('body').toggleClass('eb-menu-icon-btn--active');
  });

})(jQuery);

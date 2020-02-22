;(function($){
    //-----------------------------------------------------
  // Menu icon
  $('.ebjs-menu-icon-toggle').each(function(i, b) {
    let $this = $(b);
    $this.on('click', function(e) {
      e.preventDefault();
      $this.toggleClass('eb-menu-icon-btn--toggled');
      $('body').toggleClass('eb-menu-icon-btn--toggled');
    })
  });

})(jQuery);

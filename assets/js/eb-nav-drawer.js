;(function($){
    const burger = $('.ebjs-nav-toggle');
  
    const parentItems = $('.eb-mobile-nav-menu').find('.menu-item-has-children > .eb-nav-link');
  
    const submenus = $('.menu-item-has-children > ul');
  
    burger.each(function(i, b) {
      let $this = $(b);
      $this.on('click', function(e) {
        e.preventDefault();
        $this.toggleClass('eb-nav-toggle--open');
        $('body').toggleClass('eb-mobile-nav-open');
      })
    });
  
    parentItems.each(function(i, b) {
      let $this = $(b);
      let ind = 0;
  
      $this.append('<span class="eb-nav-indicator">+</span>');
  
      $this.on('click', function(e) {
        e.preventDefault();
        let sub = $this.next('ul');
        ind = !ind;
        $('.eb-nav-indicator').text('+');
        $('.eb-nav-indicator', $this).text((ind ? '-' : '+'));
        submenus.not(sub).slideUp();
        sub.delay(200).slideToggle();
      })
    });
  })(jQuery);
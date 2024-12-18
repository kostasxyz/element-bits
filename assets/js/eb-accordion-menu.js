;( function($) {
  /**
   * @param $scope The Widget wrapper element as a jQuery element
   * @param $ The jQuery alias
   */

  var widget = function( $scope, $ ) {

    var menu = $scope.find('ul.menu');
    var parents = menu.find('li.menu-item-has-children');
    var submenus = parents.find('ul.sub-menu');
    var currInd;

    menu.on('click', '.ntr-nav-item:not(.menu-item-has-children) a', function(event) {
      elementorProFrontend.modules.popup.closePopup( {}, event);
    });

    function toggleInd(val) {
      return val === '+' ? '-' : '+';
    }

    function currInd(target) {
      return $(target).find('.eb-accordion-wp-menu-indicator').text();
    }

    if(parents.length) {
      var links = parents.find('> a');
      var indEl = document.createElement('span');
      indEl.classList.add('eb-accordion-wp-menu-indicator');
      indEl.innerHTML = ' +';
      links.append(indEl);
      links.on('click', function(e) {
        console.log(e)
        e.preventDefault();
        var curr = $(e.currentTarget).next('.sub-menu');
        submenus.not(curr).slideUp();
        curr.stop(1,1).slideToggle();
        links.not(e.currentTarget).find('.eb-accordion-wp-menu-indicator').text(' +');
        var ind = $(e.currentTarget).find('.eb-accordion-wp-menu-indicator');
        ind.text(ind.text() == ' +' ? ' -' : ' +');
      });
    }
  };

  // Make sure you run this code under Elementor.
  $(window).on( 'elementor/frontend/init', function() {
    elementorFrontend.hooks.addAction( 'frontend/element_ready/eb-accordion-wp-menu.default', widget );
  } );
} )( jQuery );

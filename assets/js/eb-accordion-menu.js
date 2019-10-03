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

    function toggleInd(val) {
      return val === '+' ? '-' : '+';
    }

    if(parents.length) {
      var links = parents.find('> a');
      links.append(' <span class="eb-accordion-wp-menu-indicator">+</span>');
      links.on('click', function(e) {
        e.preventDefault();
        var curr = $(e.currentTarget).next('.sub-menu');
        submenus.not(curr).slideUp();
        curr.stop(1,1).slideToggle();
        links.not(curr).find('.eb-accordion-wp-menu-indicator').text('+');
        $('> a', e.currentTarget).find('.eb-accordion-wp-menu-indicator')[0].innerHTML = toggleInd($('> a', e.currentTarget).find('.eb-accordion-wp-menu-indicator')[0].innerHTML);
      });
    }
  };

  // Make sure you run this code under Elementor.
  $(window).on( 'elementor/frontend/init', function() {
    elementorFrontend.hooks.addAction( 'frontend/element_ready/eb-accordion-wp-menu.default', widget );
  } );
} )( jQuery );
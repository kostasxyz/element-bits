;(function($) {
    'use strict';

    var ebAccordionMenuWidget = function($scope, $) {
        var $menu = $scope.find('ul.menu');
        var $parents = $menu.find('li.menu-item-has-children');
        var $submenus = $parents.find('ul.sub-menu');

        // Handle click on non-parent menu items
        $menu.on('click', '.ntr-nav-item:not(.menu-item-has-children) a', function(event) {
            if (typeof elementorProFrontend !== 'undefined' && 
                elementorProFrontend.modules && 
                elementorProFrontend.modules.popup) {
                elementorProFrontend.modules.popup.closePopup({}, event);
            }
        });

        // Setup parent menu items
        if ($parents.length) {
            var $links = $parents.find('> a');
            
            // Add indicators to parent menu items
            $links.each(function() {
                var $indicator = $('<span>', {
                    'class': 'eb-accordion-wp-menu-indicator',
                    'text': ' +'
                });
                $(this).append($indicator);
            });

            // Handle click on parent menu items
            $links.on('click', function(e) {
                e.preventDefault();
                var $currentLink = $(this);
                var $currentSubmenu = $currentLink.next('.sub-menu');
                var $currentIndicator = $currentLink.find('.eb-accordion-wp-menu-indicator');

                // Close other submenus
                $submenus.not($currentSubmenu).slideUp();
                $links.not($currentLink).find('.eb-accordion-wp-menu-indicator').text(' +');

                // Toggle current submenu
                $currentSubmenu.stop(true, true).slideToggle();
                $currentIndicator.text($currentIndicator.text().trim() === '+' ? ' -' : ' +');
            });
        }
    };

    // Initialize widget using ElementBits system
    $(window).on('elementor/frontend/init', function() {
        if (typeof ElementBits !== 'undefined') {
            ElementBits.initWidget('eb-accordion-menu.default', ebAccordionMenuWidget);
        } else {
            console.warn('ElementBits core not loaded');
            elementorFrontend.hooks.addAction('frontend/element_ready/eb-accordion-menu.default', ebAccordionMenuWidget);
        }
    });

})(jQuery);

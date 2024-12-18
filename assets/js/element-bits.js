;(function($) {
    'use strict';

    // Initialize ElementBits
    window.ElementBits = {
        // Common functions and utilities
        utils: {
            isElementorPopup: function($scope) {
                return $scope.closest('.elementor-location-popup').length > 0;
            }
        },
        
        // Widget initialization registry
        widgets: {},

        // Initialize a widget
        initWidget: function(widgetName, callback) {
            if (typeof elementorFrontend !== 'undefined') {
                elementorFrontend.hooks.addAction('frontend/element_ready/' + widgetName, callback);
            }
        }
    };

    // Menu icon functionality
    $(document).on('click', '.ebjs-menu-icon-toggle', function(e) {
        e.preventDefault();
        $('body').toggleClass('eb-menu-icon-btn--toggled eb-menu-icon-btn--active');
    });

    $(document).on('elementor/popup/hide', function(event, id, instance) {
        if ($(instance.$element.find('.eb-accordion-wp-menu-list')).length) {
            $('body').removeClass('eb-menu-icon-btn--toggled eb-menu-icon-btn--active');
        }
    });

    // Handle AJAX requests
    ElementBits.ajax = function(action, data) {
        return $.ajax({
            url: ebits.ajaxurl,
            type: 'POST',
            data: $.extend({}, data, {
                action: action,
                nonce: ebits.nonce
            })
        });
    };

    // Initialize on Elementor frontend load
    $(window).on('elementor/frontend/init', function() {
        console.log('ElementBits initialized');
    });

})(jQuery);

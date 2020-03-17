;( function($) {
  /**
   * @param $scope The Widget wrapper element as a jQuery element
   * @param $ The jQuery alias
   */

  var widget = function( $scope, $ ) {

    var wrapper = $scope.find('.eb-widget-wrapper');
    var data = wrapper.data('elbits');

    console.log(data);

    init();

    function init() {
      var loc = { lat: data.lat, lng: data.lng };

      var map = new google.maps.Map(document.getElementById(data.map_id), {
        zoom: data.zoom,
        center: loc,
        scrollwheel: data.scroll,
        // draggable: data.scroll,
        styles: wrapper.data('eb-map-style')
      });

      var marker = new google.maps.Marker({
        position: loc,
        icon: data.icon,
        map: map
      });

      if(data.info) {
        var infowindow = new google.maps.InfoWindow({
          content: data.info
        });

        marker.addListener('click', function() {
          infowindow.open(map, marker);
        });
      }
    }
  };

  // Make sure you run this code under Elementor.
  $(window).on( 'elementor/frontend/init', function() {
    elementorFrontend.hooks.addAction( 'frontend/element_ready/eb-google-map.default', widget );
  } );
} )( jQuery );
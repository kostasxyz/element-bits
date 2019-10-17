;( function($) {
  /**
   * @param $scope The Widget wrapper element as a jQuery element
   * @param $ The jQuery alias
   */

  var widget = function( $scope, $ ) {
    var wrapper       = $scope.find('.eb-widget-warpper');
    var data          = wrapper.data('eb-data');
    var slickElements = wrapper.find('.eb-novi-gallery-slides');
    var navBtns       = wrapper.find('.eb-novi-gallery-tabs button');
    var btns          = slickElements.find('figure > a');
    var mobileNav     = wrapper.find('.eb-novi-gallery-mobile-nav');

    if (!slickElements.length) {
      return;
    }

    slickElements.find('.eb-novi-gallery-container').justifiedGallery({
      selector: 'figure, div:not(.spinner), div:not(.eb-loading-wrapper)',
      rowHeight: data.row_h || 180,
      margins: data.img_gap || 5,
    }).on('jg.complete', function(){
      $('.eb-loading-wrapper').fadeOut();
    });

    slickElements.slick({
      infinite: true,
      slidesToShow: 1,
      slidesToScroll: 1,
      arrows: false,
      lazyLoad: 'ondemand',
      fade: true,
    });

    navBtns.on('click', function() {
      navBtns.removeClass('eb-active');
      $(this).addClass('eb-active');
      slickElements.slick('slickGoTo', parseInt($(this).data('idx')));
    });


    var pswpElement = document.querySelectorAll('.pswp')[0];
    btns.on('click', function(e) {
      e.preventDefault();
      var pswpOtions = {
        index: $(this).data('eb-idx'),
        history: false,
        focus: false,
      };
      var gallery = new PhotoSwipe( pswpElement, PhotoSwipeUI_Default, data.img_items, pswpOtions);
      gallery.init();
    });

    // var dropdown = document.createElement('select');
    //
    // navBtns.each(function (i, b) {
    //   var option = document.createElement('option');
    //   option.setAttribute('value', i);
    //   option.innerHTML = 'xxx-'+i;
    //   console.log(b);
    //   dropdown.appendChild(option);
    // });
    // mobileNav.append(dropdown);

  };

  // Make sure you run this code under Elementor.
  $(window).on( 'elementor/frontend/init', function() {
    elementorFrontend.hooks.addAction( 'frontend/element_ready/eb-novi-gallery.default', widget );
  } );
} )( jQuery );

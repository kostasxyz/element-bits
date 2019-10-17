;(function(){

  var openBtns = document.querySelectorAll('.ntrjs-eb-lang-switch-handle');

    // instanciate new modal
    var modal = new tingle.modal({
        footer: false,
        stickyFooter: false,
        closeMethods: ['overlay', 'button', 'escape'],
        cssClass: ['eb-wpml-lang-switch-modal', 'eb-tingle-modal'],
        onOpen: function() {},
        onClose: function() {},
        beforeClose: function() {
          return true; // close the modal
      }
    });

  for(var i = 0; i < openBtns.length; i++) {
    openBtns[i].addEventListener('click', function(evt) {
      evt.stopPropagation();
      evt.preventDefault();

      const content = document.querySelector('[data-eb-modal="' + this.dataset.ebEid + '"]').innerHTML;

      modal.setContent(content);
      modal.open();
    });
  }

})(jQuery);

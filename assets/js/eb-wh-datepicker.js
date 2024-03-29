;(function($){
  var ebDatepickerWidget = function( $scope, $ ) {
    var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    var wrapper            = $scope.find('.eb-datepicker-wrapper');
    var dataProps          = wrapper.data('elbits');
    var checkinField       = wrapper.find('.eb-datepicker-field-checkin');
    var checkoutField      = wrapper.find('.eb-datepicker-field-checkout');
    var checkinDisplay     = checkinField.find('.eb-datepicker-field-display');
    var checkoutDisplay    = checkoutField.find('.eb-datepicker-field-display');
    var bookBtn            = wrapper.find('.eb-datepicker-book-btn');
    var addGuest           = wrapper.find('.eb-number-field-add');
    var subGuest           = wrapper.find('.eb-number-field-sub');
    var guestNum           = wrapper.find('.eb-number-field-num');
    var guests             = dataProps.def_guests ?? 2;

    var bookUrl = dataProps.book_url ?? 'https://myhotel.reserve-online.net';


    var checkinPicker = checkinField.flatpickr({
      altFormat: "F j, Y",
      dateFormat: "d-m-Y",
      defaultDate: Date.now(),
      onChange: function(selectedDates, dateStr, instance) {
        handleDateChange('in', selectedDates, instance);
      }
    });

    var checkoutPicker = checkoutField.flatpickr({
      altFormat: "Y-m-d",
      dateFormat: "Y-m-d",
      defaultDate: new Date(Date.now() + ((2 * 24) * 3600 * 1000)),
      onChange: function(selectedDates, dateStr, instance) {
        handleDateChange('out', selectedDates, instance);
      }
    });

    function buildBookUrl() {

      var checkin = '?checkin=' + getDate(checkinPicker.selectedDates).qstr;

      var checkout = '&checkout=' + getDate(checkoutPicker.selectedDates).qstr;

      var guestsVal = '&adults=' + guests;

      return bookUrl + checkin + checkout + guestsVal;
    }

    // Make an object with needed structure
    function getDate(dateObj, offset) {

      var date = new Date(dateObj) || Date.now();

      if(offset) {
        date.setDate(dateObj.getDate() + offset);
      }

      return {
        year: date.getFullYear(),
        month: months[date.getMonth()],
        day: leadingZero(date.getDate()),
        qstr: leadingZero(date.getDate()) + '-' + leadingZero(date.getMonth()+1) + '-' + date.getFullYear(),
        date: date
      }
    }

    // Add 0 to 1 digit vals
    function leadingZero(num) {
      return num < 10 ? '0' + num : '' + num;
    }

    function displayDate(dateObj, offset) {
      offset = offset || 0;
      var data = getDate(dateObj, offset);
      return data.day + ' ' + data.month;
    }

    function checkoutGreaterThanCheckin() {
      var checkin = new Date(checkinPicker.selectedDates);
      var checkout = new Date(checkoutPicker.selectedDates);

      checkin.setHours(0,0,0,0);
      checkout.setHours(0,0,0,0);

      return checkout > checkin;
    }

    function handleDateChange(field, selectedDates, instance) {
      field = field || 'in';

      var dates = getDate(selectedDates[0]);

      instance.setDate(dates.date);

      if(field === 'in') {
        checkinDisplay.text(displayDate(dates.date));
        if(!checkoutGreaterThanCheckin()) {
          checkoutDisplay.text(displayDate(dates.date, 2));
          checkoutPicker.setDate(getDate(dates.date, 2).date);
        }
      }
      else {
        checkoutDisplay.text(displayDate(dates.date));
        if(!checkoutGreaterThanCheckin()) {
          checkinDisplay.text(displayDate(dates.date, -2));
          checkinPicker.setDate(getDate(dates.date, -2).date);
        }
      }

      bookBtn.attr('href', buildBookUrl());
    }


    addGuest.on('click', function(ev) {
      if(guests < dataProps.max_guests ?? 6) {
        guests += 1;
        guestNum.text(guests);
      }

      bookBtn.attr('href', buildBookUrl());
    });

    subGuest.on('click', function(){
      if(guests > 1) {
          guests -= 1;
          guestNum.text(guests);
      }

      bookBtn.attr('href', buildBookUrl());
    });

  };

    // Make sure you run this code under Elementor.
  $(window).on( 'elementor/frontend/init', function() {
    elementorFrontend.hooks.addAction( 'frontend/element_ready/eb-wh-datepicker.default', ebDatepickerWidget );
  } );
})(jQuery);

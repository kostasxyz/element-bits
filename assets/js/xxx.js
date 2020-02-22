;(function($){
  var ebDatepickerWidget = function( $scope, $ ) {
    var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    var wrapper           = $scope.find('.eb-datepicker-wrapper');
    var checkinHandle     = wrapper.find('.eb-datepicker-field-checkin');
    var checkoutHandle    = wrapper.find('.eb-datepicker-field-checkout');
    var guestHandle       = wrapper.find('.eb-datepicker-field-guests');
    var checkinDateText   = checkinHandle.find('.eb-datepicker-field-date-text');
    var checkoutDateText  = checkoutHandle.find('.eb-datepicker-field-date-text');
    var guests            = 2;
    var guestHandle       = wrapper.find('.eb-datepicker-field-guests');
    var guestNum          = wrapper.find('.eb-datepicker-field-guests .eb-number-field-num');
    var addGuestHandle    = wrapper.find('.eb-datepicker-field-guests .eb-number-field-add');
    var subGuestHandle    = wrapper.find('.eb-datepicker-field-guests .eb-number-field-sub');
    var submitBtn         = wrapper.find('.eb-datepicker-book-btn');
    var bookUrl;
    try {
      bookUrl = wrapper.data('elbits').book_url;
    } catch (err) {
      bookUrl = 'https://myhotel.reserve-online.net';
    }

    var userSelectedCheckout = false;

    // Add 0 to 1 digit vals
    function leadingZero(num) {
      return num < 10 ? '0' + num : num;
    }

    // Make an object with needed structure
    function getDate(days) {
      var add = 0;
      if(days) {
        add = (days * 24) * 3600 * 1000;
      }
      var date = new Date(Date.now() + add);

      return {
        date: {
          year: date.getFullYear(),
          month: months[date.getMonth()],
          date: leadingZero(date.getDate()),
        },
        pickerDate: [
          date.getFullYear(),
          date.getMonth(),
          date.getDate(),
        ]
      }
    }

    // Build book url based on selected vals
    function buildBookUrl(arr, dep) {
      var checkin = '?checkin=' + arr.year + '-' + leadingZero(arr.month+1) + '-' + leadingZero(arr.date);

      var checkout = '&checkout=';

      if(dep) {
        checkout += dep.year + '-' + leadingZero(dep.month+1) + '-' + leadingZero(dep.date);
      }

      var guestsVal = '&adults=' + parseInt(guests);

      return bookUrl + checkin + checkout + guestsVal;
    }


    if(checkinHandle && checkoutHandle) {
      checkinHandle.pickadate({
        selectYears: true,
        selectMonths: true,
        format: 'dd mmm',
        formatSubmit: 'yyyy-mm-dd',
      });

      checkoutHandle.pickadate({
        selectYears: true,
        selectMonths: true,
        format: 'dd mmm',
        formatSubmit: 'yyyy-mm-dd',
      });

      var checkinPicker = checkinHandle.pickadate('picker');
      var checkoutPicker  = checkoutHandle.pickadate('picker');

      checkinPicker.set('min', true);
      checkoutPicker.set('min', true);

      var today = getDate(0);
      checkinPicker.set('select', today.pickerDate);
      checkinDateText.html(today.date.date + ' ' + today.date.month);

      var todayPlus = getDate(2);
      checkoutPicker.set('select', todayPlus.pickerDate);
      checkoutDateText.html(todayPlus.date.date + ' ' + todayPlus.date.month);

      // On arrival datepicker set
      checkinPicker.on('set', function(data) {
        var checkinDate   = checkinPicker.get('select');
        var checkoutDate  = checkoutPicker.get('select');

        if(checkinDate && (!checkoutDate || (checkoutDate && checkoutDate.pick <= checkinDate.pick))) {
          var datePlus = new Date(checkinDate.pick);
          datePlus.setDate(datePlus.getDate() + 2);
          checkoutPicker.set('select', datePlus);
        }

        var newDate = new Date(data.select);
        var date    = leadingZero(newDate.getDate());
        var month   = newDate.getMonth();

        checkinDateText.html(date + ' ' + months[month]);

        var arr = checkinPicker.get('select');
        var dep = checkoutPicker.get('select');

        submitBtn.attr('href', buildBookUrl(arr, dep));

        userSelectedDeparture = true;
      });

      //-------------------------------------------------------
      // On depart datepicker set
      checkoutPicker.on('set', function(data) {
        var checkinDate   = checkinPicker.get('select');
        var checkoutDate  = checkoutPicker.get('select');

        if(checkoutDate && (!checkinDate || (checkinDate && checkoutDate.pick <= checkinDate.pick))) {
          var dateMinus = new Date(checkoutDate.pick);
          dateMinus.setDate(dateMinus.getDate() - 2);
          checkinPicker.set('select', dateMinus);
          checkinDateText.html(leadingZero(dateMinus.getDate() - 2) + ' ' + months[newDate.getMonth()]);
        }

        var newDate = new Date(data.select);
        var date    = leadingZero(newDate.getDate());
        var month   = newDate.getMonth();

        checkoutDateText.html(date + ' ' + months[month]);

        var arr = checkinPicker.get('select');
        var dep = checkoutPicker.get('select');

        submitBtn.attr('href', buildBookUrl(arr, dep));
      });
    }


    addGuestHandle.on('click', function(ev) {
      if(guests < 8) {
        guests += 1;
        guestNum.text(guests);
      }

      var arr = checkinPicker.get('select');
      var dep = checkoutPicker.get('select');

      submitBtn.attr('href', buildBookUrl(arr, dep));
    });

    subGuestHandle.on('click', function(){
      if(guests > 1) {
          guests -= 1;
          guestNum.text(guests);
      }

      var arr = checkinPicker.get('select');
    });

  };

    // Make sure you run this code under Elementor.
  $(window).on( 'elementor/frontend/init', function() {
    elementorFrontend.hooks.addAction( 'frontend/element_ready/eb-wh-datepicker.default', ebDatepickerWidget );
  } );
})(jQuery);

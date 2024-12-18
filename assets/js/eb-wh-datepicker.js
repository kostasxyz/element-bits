;(function($) {
  var ebDatepickerWidget = function($scope, $) {
    const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    const wrapper = $scope.find('.eb-datepicker-wrapper');

    // Validate required elements
    if (!wrapper.length) {
      console.error('Datepicker wrapper not found');
      return;
    }

    const dataProps = wrapper.data('elbits') || {};
    const {
      book_url = 'https://myhotel.reserve-online.net',
      def_guests = 2,
      max_guests = 6
    } = dataProps;

    // Cache DOM elements
    const elements = {
      checkinField: wrapper.find('.eb-datepicker-field-checkin'),
      checkoutField: wrapper.find('.eb-datepicker-field-checkout'),
      checkinDisplay: wrapper.find('.eb-datepicker-field-checkin .eb-datepicker-field-display'),
      checkoutDisplay: wrapper.find('.eb-datepicker-field-checkout .eb-datepicker-field-display'),
      bookBtn: wrapper.find('.eb-datepicker-book-btn'),
      addGuest: wrapper.find('.eb-number-field-add'),
      subGuest: wrapper.find('.eb-number-field-sub'),
      guestNum: wrapper.find('.eb-number-field-num')
    };

    let guests = def_guests;

    // Helper Functions
    const leadingZero = num => num < 10 ? `0${num}` : `${num}`;

    const getDate = (dateObj, offset = 0) => {
      try {
        const date = dateObj ? new Date(dateObj) : new Date();
        
        if (isNaN(date.getTime())) {
          throw new Error('Invalid date provided');
        }

        if (offset) {
          date.setDate(date.getDate() + offset);
        }

        return {
          year: date.getFullYear(),
          month: months[date.getMonth()],
          day: leadingZero(date.getDate()),
          qstr: `${leadingZero(date.getDate())}-${leadingZero(date.getMonth() + 1)}-${date.getFullYear()}`,
          date: date
        };
      } catch (error) {
        console.error('Date parsing error:', error);
        // Return current date as fallback
        return getDate(new Date());
      }
    };

    const displayDate = (dateObj, offset = 0) => {
      const data = getDate(dateObj, offset);
      return data ? `${data.day} ${data.month}` : '';
    };

    const buildBookUrl = () => {
      try {
        const checkin = `?checkin=${getDate(checkinPicker.selectedDates).qstr}`;
        const checkout = `&checkout=${getDate(checkoutPicker.selectedDates).qstr}`;
        const guestsVal = `&adults=${guests}`;
        return `${book_url}${checkin}${checkout}${guestsVal}`;
      } catch (error) {
        console.error('Error building booking URL:', error);
        return book_url;
      }
    };

    const checkoutGreaterThanCheckin = () => {
      try {
        const checkin = new Date(checkinPicker.selectedDates);
        const checkout = new Date(checkoutPicker.selectedDates);

        checkin.setHours(0, 0, 0, 0);
        checkout.setHours(0, 0, 0, 0);

        return checkout > checkin;
      } catch (error) {
        console.error('Error comparing dates:', error);
        return false;
      }
    };

    const handleDateChange = (field = 'in', selectedDates, instance) => {
      try {
        const dates = getDate(selectedDates[0]);
        if (!dates) return;

        instance.setDate(dates.date);

        if (field === 'in') {
          elements.checkinDisplay.text(displayDate(dates.date));
          if (!checkoutGreaterThanCheckin()) {
            elements.checkoutDisplay.text(displayDate(dates.date, 2));
            checkoutPicker.setDate(getDate(dates.date, 2).date);
          }
        } else {
          elements.checkoutDisplay.text(displayDate(dates.date));
          if (!checkoutGreaterThanCheckin()) {
            elements.checkinDisplay.text(displayDate(dates.date, -2));
            checkinPicker.setDate(getDate(dates.date, -2).date);
          }
        }

        elements.bookBtn.attr('href', buildBookUrl());
      } catch (error) {
        console.error('Error handling date change:', error);
      }
    };

    // Initialize Flatpickr
    const checkinPicker = elements.checkinField.flatpickr({
      altFormat: "F j, Y",
      dateFormat: "d-m-Y",
      defaultDate: Date.now(),
      onChange: (selectedDates, dateStr, instance) => handleDateChange('in', selectedDates, instance)
    });

    const checkoutPicker = elements.checkoutField.flatpickr({
      altFormat: "Y-m-d",
      dateFormat: "Y-m-d",
      defaultDate: new Date(Date.now() + (2 * 24 * 3600 * 1000)),
      onChange: (selectedDates, dateStr, instance) => handleDateChange('out', selectedDates, instance)
    });

    // Event Handlers
    elements.addGuest.on('click', () => {
      if (guests < max_guests) {
        guests += 1;
        elements.guestNum.text(guests);
        elements.bookBtn.attr('href', buildBookUrl());
      }
    });

    elements.subGuest.on('click', () => {
      if (guests > 1) {
        guests -= 1;
        elements.guestNum.text(guests);
        elements.bookBtn.attr('href', buildBookUrl());
      }
    });

    // Cleanup function
    return function() {
      if (checkinPicker) checkinPicker.destroy();
      if (checkoutPicker) checkoutPicker.destroy();
      elements.addGuest.off('click');
      elements.subGuest.off('click');
    };
  };

  // Initialize widget
  $(window).on('elementor/frontend/init', function() {
    elementorFrontend.hooks.addAction('frontend/element_ready/eb-wh-datepicker.default', ebDatepickerWidget);
  });
})(jQuery);

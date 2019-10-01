import * as Ladda from 'ladda';
import Turbolinks from 'turbolinks';

require('./bootstrap');

window.Vue = require('vue');

// Register components...
Vue.component('notification', require('./components/Notification.vue').default);
Vue.component('form-confirm', require('./components/FormConfirm.vue').default);
Vue.component('date-picker', require('./components/Datepicker.vue').default);
Vue.component('date-time-picker', require('./components/DateTimePicker.vue').default);
Vue.component('input-selector', require('./components/InputSelector.vue').default);

// Construct a new Vue instance when turbolinks loads...
$(document).on('turbolinks:load', () => {
    const app = new Vue({
        el: '#app',
    });

    // Enable tooltips.
    $('[data-toggle="tooltip"]').tooltip();

    // Enable ladda.
    Ladda.bind('button[type=submit]:not(.no-loading)');

    // Autofocus the first input on modal windows.
    $(document).on('shown.bs.modal', function () {
        $(this).find('[autofocus]').focus();
    });

    // Show / hide modals when included as an anchor in the URL.
    $('.modal').on('show.bs.modal hide.bs.modal', function (e) {
        let url = window.location.origin + window.location.pathname;

        if (e.type === 'show') {
            url = url + '#' + $(e.target).attr('id');
        }

        window.history.replaceState(window.history.state, "", url);
    });

    // Open modals if they are included in the URL hash.
    let hash = location.hash;

    if (hash) {
        let modal = $(hash);

        // Determine if the given has is a modal.
        if (
            modal.attr('class') !== undefined &&
            modal.attr('class').includes('modal')
        ) {
            modal.modal('show');
        }
    }
});

// Boot Turbolinks...
Turbolinks.start();

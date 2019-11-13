
import './bootstrap';
import Swal from 'sweetalert2';
import Trix from 'trix';
import Turbolinks from 'turbolinks';
import { Application } from 'stimulus';
import Loader from './loading-indicator';
import { definitionsFromContext } from 'stimulus/webpack-helpers';

// Start Stimulus.
const application = Application.start();
const context = require.context('./controllers', true, /\.js$/);
application.load(definitionsFromContext(context));

// Boot Turbolinks...
Turbolinks.start();

document.addEventListener('turbolinks:load', () => {
    // Enable ladda.
    Loader.bind();
});

document.addEventListener('turbolinks:before-cache', () => {
    // Tear down swal.
    Swal.close();
});

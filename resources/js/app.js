
import './bootstrap';
import Trix from 'trix';
import Swal from 'sweetalert2';
import Turbolinks from 'turbolinks';
import { Application } from 'stimulus';
import Toaster from './toaster';
import Loader from './loading-indicator';
import { definitionsFromContext } from 'stimulus/webpack-helpers';

// Start Stimulus.
const application = Application.start();
const context = require.context('./controllers', true, /\.js$/);
application.load(definitionsFromContext(context));

// Boot Turbolinks...
Turbolinks.start();

// Persist scroll position with Turbolinks.
Turbolinks.scroll = {};

document.addEventListener('turbolinks:load', () => {
    // Enable ladda.
    Loader.bind();

    const elements = document.querySelectorAll("[data-turbolinks-scroll]");

    elements.forEach((element) => {
        element.addEventListener("click", () => {
            Turbolinks.scroll['top'] = document.scrollingElement.scrollTop;
        });

        element.addEventListener("submit", () => {
            Turbolinks.scroll['top'] = document.scrollingElement.scrollTop;
        });
    });

    if (Turbolinks.scroll['top']) {
        document.scrollingElement.scrollTo(0, Turbolinks.scroll['top']);
    }

    Turbolinks.scroll = {};
});

document.addEventListener("turbolinks:request-start", () => {
    // Remove any toasters before the request starts so caching does not pick it up.
    Toaster.clear();
});

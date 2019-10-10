
import './bootstrap';

import * as Ladda from 'ladda';
import Turbolinks from 'turbolinks';
import { Application } from 'stimulus';
import { definitionsFromContext } from 'stimulus/webpack-helpers';

// Start Stimulus.
const application = Application.start();
const context = require.context('./controllers', true, /\.js$/);
application.load(definitionsFromContext(context));

// Boot Turbolinks...
Turbolinks.start();

$(document).on('turbolinks:load', function () {
    // Enable ladda.
    Ladda.bind('button[type=submit]:not(.no-loading)');
});

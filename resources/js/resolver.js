import toaster from "./toaster";

export default class Resolver {
    /**
     * Create a new resolver.
     *
     * @param {Response} response
     */
    constructor(response) {
        this.response = response;
    }

    /**
     * Resolve the response.
     */
    resolve() {
        if (this.isSuccessfulResponse()) {
            this.complete();
        } else {
            this.error();
        }
    }

    /**
     * Completes a successful response.
     */
    complete() {
        // Flush the cache if the response requires is.
        if (!this.isCaching()) {
            this.flushCache();
        }

        // Define the after callback and display a notification if requested.
        // This callback allows us to execute operations after turbolinks
        // finishes loading / replacing the page.
        let after = () => {
            this.after.call();

            if (this.isNotifying()) {
                this.fireNotification();
            }

            document.removeEventListener('turbolinks:load', after, false);
        };

        document.addEventListener('turbolinks:load', after, false);

        if (this.isRedirecting()) {
            this.visit(this.getResponseUrl());
        } else {
            this.replace(this.getResponseUrl());
        }
    }

    /**
     * Displays an error notification.
     */
    error() {
        this.fireNotification();
    }

    /**
     * Set the callback to run after resolving.
     *
     * @param {Closure} closure
     */
    afterResolving(closure) {
        this.after = closure;
    }

    /**
     * Replace the current page with the given URL's content.
     *
     * @param {String} url
     */
    replace(url) {
        this.visit(url, 'replace');
    }

    /**
     * Advance to the given URL.
     *
     * @param {String} url
     */
    advance(url) {
        this.visit(url, 'advance');
    }

    /**
     * Visit the URL with Turbolinks.
     *
     * @param {String} url
     * @param {String} action
     */
    visit(url, action = 'advance') {
        Turbolinks.visit(url, { action: action });
    }

    /**
     * Fires a notification from the response.
     */
    fireNotification() {
        toaster.fire(
            this.getResponseType(),
            this.getResponseMessage()
        );
    }

    /**
     * Flush the Turbolinks cache.
     */
    flushCache() {
        Turbolinks.clearCache();
    }

    /**
     * Determine if the response is successful.
     *
     * @returns {boolean}
     */
    isSuccessfulResponse() {
        return this.getResponseType() === 'success';
    }

    /**
     * Determine if the response requires a redirect.
     *
     * @returns {boolean}
     */
    isRedirecting() {
        return this.response.data.hasOwnProperty('redirect') &&
            this.response.data.redirect === true;
    }

    /**
     * Determine if the response requires keeping the Turoblinks cache.
     */
    isCaching() {
        return this.response.data.hasOwnProperty('cache') &&
            this.response.data.cache === true;
    }

    /**
     * Determine if the response requires notifying the user.
     *
     * @returns {boolean}
     */
    isNotifying() {
        return this.response.data.hasOwnProperty('notify') &&
            this.response.data.notify === true;
    }

    /**
     * Get the response URL.
     *
     * @returns {String}
     */
    getResponseUrl() {
        if (this.response.data.hasOwnProperty('url')) {
            return this.response.data.url;
        }
    }

    /**
     * Get the type of response (success, error).
     *
     * @returns {String}
     */
    getResponseType() {
        if (this.response.data.hasOwnProperty('type')) {
            return this.response.data.type;
        }
    }

    /**
     * Get the message from the response.
     *
     * @returns {String}
     */
    getResponseMessage() {
        if (this.response.data.hasOwnProperty('message')) {
            return this.response.data.message;
        }
    }
}

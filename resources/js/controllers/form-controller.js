import axios from 'axios';
import * as Ladda from 'ladda';
import Resolver from "../resolver";
import { Controller } from 'stimulus';

export default class extends Controller {
    static targets = ['input', 'error'];

    /**
     * Automatically bind to the form submit event.
     */
    connect() {
        this.element.addEventListener('submit', (event) => this.submit(event));
    }

    /**
     * Submit the form via XHR.
     *
     * @param {Object} event
     */
    submit(event) {
        event.preventDefault();

        this.before().then(() => {
            this.removeErrors();

            this.send()
                .then(response => this.success(response))
                .catch(error => this.error(error))
                .then(() => Ladda.stopAll());
        }).catch(() => {
            Ladda.stopAll();
        });
    }

    /**
     * Send the form request.
     *
     * @returns {Promise<void>}
     */
    send() {
        return axios({
            url: this.element.action,
            method: this.element.method,
            data: this.getFormData()
        });
    }

    /**
     * Operations to execute after a successful form response.
     *
     * @param {Object} response
     */
    success(response) {
        let resolver = new Resolver(response);

        resolver.afterResolving(() => { this.after(response); });

        resolver.resolve();
    }

    /**
     * Additional operations to run before a form submission.
     *
     * @return {Promise}
     */
    before() {
        return new Promise(resolve => { resolve(); });
    }

    /**
     * Additional operations to run after a successful form response.
     *
     * @param {Object} response
     */
    after(response) {
        //
    }

    /**
     * Operations to execute after a failed form response.
     *
     * @param {Object} error
     */
    error(error) {
        // If this is a form validation error, we'll display the form errors.
        if (error.response.status === 422) {
            this.setErrors(
                this.getErrorsFromResponse(error.response)
            );
        } else {
            (new Resolver(error.response)).resolve();
        }
    }

    /**
     * Set the form errors that were returned from the request.
     *
     * @param {Object} errors
     */
    setErrors(errors) {
        for (let input in errors) {
            document.getElementsByName(input).forEach((element) => {
                this.setError(element, _.first(errors[input]));
            });
        }
    }

    /**
     * Set an error for the given input.
     *
     * @param {Object} input
     * @param {String} message
     */
    setError(input, message) {
        input.classList.add('is-invalid');

        let error = this.getErrorByInputName(input.name);

        if (typeof error === "object") {
            error.innerHTML = message;
        }
    }

    /**
     * Clears an error from an input event.
     *
     * @param {Event} event
     */
    clearError(event) {
        this.removeError(event.target);
    }

    /**
     * Removes all errors from the form inputs.
     */
    removeErrors() {
        this.inputTargets.forEach((element) => {
            this.removeError(element);
        });
    }

    /**
     * Removes an error from the event input.
     *
     * @param {Object} element
     */
    removeError(element) {
        element.classList.remove('is-invalid');
    }

    /**
     * Get an error element by the input name.
     *
     * @param {String} input
     *
     * @returns {*}
     */
    getErrorByInputName(input) {
        return this.errorTargets.find(element => element.dataset.input === input);
    }

    /**
     * Get the serialized form data as an object for axios.
     *
     * @returns {Object}
     */
    getFormData() {
        return $(this.element)
            .serializeArray()
            .reduce((data, input) => {
                data[input.name] = input.value;

                return data;
            }, {});
    }

    /**
     * Get the errors from the given response.
     *
     * @param {Object} response
     *
     * @return {Object}
     */
    getErrorsFromResponse(response) {
        if (!response.data || typeof response.data !== 'object') {
            return { error: 'Something went wrong. Please try again later.' }
        }

        if (response.data.hasOwnProperty('errors')) {
            return { ...response.data.errors }
        }

        if (response.data.hasOwnProperty('message')) {
            return { error: response.data.message }
        }

        return { ...response.data }
    }
}

import axios from 'axios';
import * as Ladda from 'ladda';
import Turbolinks from 'turbolinks';
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

        this.removeErrors();

        axios.post(this.element.action, this.getFormData())
            .then(response => this.success(response))
            .catch(error => this.error(error))
            .then(() => Ladda.stopAll());
    }

    /**
     * Operations to execute after a successful form response.
     *
     * @param {Object} response
     */
    success(response) {
        Turbolinks.visit(response.headers['turbolinks-location']);
    }

    /**
     * Operations to execute after a failed form response.
     *
     * @param {Object} error
     */
    error(error) {
        this.setErrors(
            this.getErrorsFromResponse(error.response)
        );
    }

    /**
     * Set the form errors that were returned from the request.
     *
     * @param {Object} errors
     */
    setErrors(errors) {
        for (let input in errors) {
            document.getElementsByName(input).forEach((element) => {
                this.setError(element, errors[input]);
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
     * Get the serialized form data as an object.
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
        if (response.data.errors) {
            return { ...response.data.errors }
        }

        if (response.data.message) {
            return { error: response.data.message }
        }

        return { ...response.data }
    }
}

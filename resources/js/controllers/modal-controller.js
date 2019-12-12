import { Controller } from "stimulus";

export default class extends Controller {
    static targets = ['title', 'body'];

    /**
     * Load the URL into the modals content.
     *
     * @param {String} url
     *
     * @returns {Promise<string>}
     */
    load(url) {
        return fetch(url)
            .then(response => response.text())
            .then(html => {
                this.setContent(html);
            });
    }

    /**
     * Set the content of the modal.
     *
     * @param {String} html
     */
    setContent(html) {
        this.element.innerHTML = html;
    }

    /**
     * Open the modal.
     */
    open() {
        $(this.element).modal('show');
    }

    /**
     * Close the modal.
     */
    close() {
        $(this.element).modal('hide');
    }
}

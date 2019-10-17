import { Controller } from 'stimulus';

export default class extends Controller {
    static targets = ['modal', 'title', 'href'];

    /**
     * Launch the object modal.
     *
     * @param {Event} event
     */
    launch(event) {
        event.preventDefault();

        let modalController = this.getModal();
        modalController.setTitle(this.titleTarget.innerHTML);

        fetch(this.data.get("url"))
            .then(response => response.text())
            .then(html => {
                modalController.setBody(html);
                modalController.open();
            });
    }

    /**
     * Visit the object.
     *
     * @param {Event} event
     */
    visit(event) {
        event.preventDefault();

        this.getModal().close();

        Turbolinks.visit(this.hrefTarget.href);
    }

    /**
     * Get the modal associated with the object.
     *
     * @returns {Controller}
     */
    getModal() {
        return this.application.getControllerForElementAndIdentifier(
            this.modalTarget,
            "modal"
        );
    }
}

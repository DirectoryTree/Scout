import { Controller } from 'stimulus';

export default class extends Controller {
    static targets = ['container', 'button'];

    connect() {
        this.close();
    }

    /**
     * Open the container and disable the button.
     */
    open() {
        this.buttonTarget.disabled = true;
        this.containerTarget.classList.remove('d-none');
    }

    /**
     * Hide the container and enable the button.
     */
    close() {
        this.buttonTarget.disabled = false;
        this.containerTarget.classList.add('d-none');
    }
}

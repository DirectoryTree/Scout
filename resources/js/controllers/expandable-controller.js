import { Controller } from 'stimulus';

export default class extends Controller {
    static targets = ['toggle', 'container'];

    hideClass = 'd-none';

    initialize() {
        this.toggle(this.toggleTarget.checked);

        this.toggleTarget.addEventListener('click', (event) => {
            this.toggle(event.target.checked);
        });
    }

    /**
     * Toggle the container.
     *
     * @param {boolean} toggled
     */
    toggle(toggled = false) {
        toggled ? this.open() : this.close();
    }

    /**
     * Open the container.
     */
    open() {
        this.containerTarget.classList.remove(this.hideClass);
    }

    /**
     * Close the container.
     */
    close() {
        this.containerTarget.classList.add(this.hideClass);
    }
}

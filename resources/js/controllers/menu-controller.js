import { Controller } from 'stimulus';

export default class extends Controller {
    static targets = ['container', 'toggleButton'];

    /**
     * Initialize the expand button.
     */
    initialize() {
        this.showExpandButton();

        $(this.toggleButtonTarget).click(() => {
            this.toggleMenu();
        });
    }

    /**
     * Toggle the menu.
     */
    toggleMenu() {
        let container = $(this.containerTarget);

        container.toggleClass('d-none');

        if (container.hasClass('d-none')) {
            this.showExpandButton();
        } else {
            this.showHideButton();
        }
    }

    /**
     * Show the expand button.
     */
    showExpandButton() {
        this.toggleButtonTarget.innerHTML = '<i class="fa fa-angle-double-down"></i> Expand';
    }

    /**
     * Show the hide button.
     */
    showHideButton() {
        this.toggleButtonTarget.innerHTML = '<i class="fa fa-angle-double-up"></i> Hide';
    }
}

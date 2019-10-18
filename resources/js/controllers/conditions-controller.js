import ExpandController from './expand-controller';

export default class extends ExpandController {
    connect() {
        super.connect();

        this.alert = document.getElementById('alert-no-notifiers');
    }

    /**
     * Open the hidden container and hide the alert.
     */
    open() {
        super.open();

        this.hideNoNotifiersAlert();
    }

    /**
     * Close the contianer and hide the alert.
     */
    close() {
        super.close();

        this.showNoNotifiersAlert();
    }

    /**
     * Hide the 'no notifiers' alert.
     */
    hideNoNotifiersAlert() {
        if (this.alert) {
            this.alert.classList.add('d-none');
        }
    }

    /**
     * Show the 'no notifiers' alert.
     */
    showNoNotifiersAlert() {
        if (this.alert) {
            this.alert.classList.remove('d-none');
        }
    }
}

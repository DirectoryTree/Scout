import toaster from "../toaster";
import { Controller } from "stimulus"

export default class extends Controller {
    /**
     * Fire the Swal alert upon connecting.
     */
    connect() {
        toaster.fire(this.getLevel(), this.getTitle(), this.getMessage());

        this.element.remove();
    }

    /**
     * Get the title of the alert.
     *
     * @return {String}
     */
    getTitle() {
        switch (this.getLevel()) {
            case 'success':
                return 'Success';
            case 'info':
                return 'Information';
            case 'error':
                return 'Error';
            case 'warning':
                return 'Warning';
        }
    }

    /**
     * Get the message of the alert.
     *
     * @return {String}
     */
    getMessage() {
        return this.data.get('message');
    }

    /**
     * Get the level of alert.
     *
     * @return {String}
     */
    getLevel() {
        return this.data.get('level');
    }
}

import { Controller } from "stimulus"
import Swal from 'sweetalert2';

export default class extends Controller {
    /**
     * Fire the Swal alert upon connecting.
     */
    connect() {
        Swal.fire({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            type: this.getLevel(),
            title: this.getTitle(),
            text: this.getMessage(),
        });

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

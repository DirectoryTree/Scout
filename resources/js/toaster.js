import Swal from "sweetalert2";

export default class {
    /**
     * Fire a toast alert.
     *
     * @param {String} type
     * @param {String} title
     * @param {String} message
     */
    static fire(type, title, message) {
        Swal.fire({
            toast: true,
            position: 'top',
            showConfirmButton: false,
            timer: 3000,
            type: type,
            title: title,
            text: message,
        });
    }
}

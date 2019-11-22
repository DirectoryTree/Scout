import Swal from "sweetalert2";

export default class Toaster {
    /**
     * Fire a toast alert.
     *
     * @param {String} type
     * @param {String} title
     * @param {String} message
     */
    static fire(type, title, message = '') {
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

    /**
     * Generate a confirmation promise.
     *
     * @returns {Promise<SweetAlertResult>}
     */
    static confirm(title, message) {
        return Swal.fire({
            reverseButtons:true,
            showCancelButton: true,
            showConfirmButton: true,
            type: 'warning',
            title: title,
            text: message,
            animation:false,
        }).then((result) => {
            if (!result.value) {
                throw "Cancelled";
            }
        });
    }

    /**
     * Remove all toasters from the DOM.
     */
    static clear()
    {
        let toasters = document.getElementsByClassName('swal2-container');

        for(let i = 0; i < toasters.length; i++) {
            toasters[i].remove();
        }
    }
}

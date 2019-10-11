import Swal from "sweetalert2";

export default class {
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

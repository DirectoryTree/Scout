import Swal from 'sweetalert2';
import * as Ladda from 'ladda';
import { Controller } from 'stimulus';

export default class extends Controller {
    /**
     * Prevent form submissions from occurring until confirmed.
     *
     * @param {Object} event
     */
    confirm(event) {
        event.preventDefault();

        Swal.fire({
            reverseButtons:true,
            showCancelButton: true,
            showConfirmButton: true,
            type: 'warning',
            title: this.data.get('title'),
            text: this.data.get('message'),
            animation:false,
        }).then((result) => {
            if (result.value) {
                // Submit the form upon confirmation.
                event.target.submit();
            } else {
                Ladda.stopAll();
            }
        }).catch(() => {
            Ladda.stopAll();
        });
    }
}

import flatpickr from 'flatpickr';
import { Controller } from 'stimulus';

export default class extends Controller {
    initialize() {
        this.config = {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
        };
    }

    connect() {
        this.picker = flatpickr(this.element, this.config);
    }
}

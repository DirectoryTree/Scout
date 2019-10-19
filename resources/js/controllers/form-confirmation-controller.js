import toaster from "../toaster";
import FormController from './form-controller';

export default class extends FormController {
    /**
     * Prevent form submissions from occurring until confirmed.
     *
     * @returns {Promise<SweetAlertResult>}
     */
    before() {
        return toaster.confirm(this.data.get('title'), this.data.get('message'));
    }
}

import toaster from "../../toaster";
import FormController from '../form-xhr-controller';

export default class extends FormController {
    after(response) {
        toaster.fire('success', 'Success', this.data.get('message'));
    }
}

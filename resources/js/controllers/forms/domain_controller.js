import toaster from "../../toaster";
import FormController from '../form-xhr_controller';

export default class extends FormController {
    after(response) {
        toaster.fire('success', 'Saved', this.data.get('saved-message'));
    }
}

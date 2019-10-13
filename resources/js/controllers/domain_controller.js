import toaster from "../toaster";
import FormController from './form-xhr_controller';

export default class extends FormController {
    success(response) {
        toaster.fire('success', 'Saved', 'Updated domain.');
    }
}

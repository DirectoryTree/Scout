import FormController from '../form-controller';

export default class extends FormController {
    /**
     * Hides the value input depending on the selected operator.
     *
     * @param {Event} event
     */
    hideValueInput(event) {
        let select = event.target;

        // Get the nullabe operators from the input.
        let nullableOperators = JSON.parse(select.dataset.nullableOperators);

        // Get the value input.
        let element = $(this.element).find('input[name=value]');

        if (element.length) {
            let input = element.get(0);

            if (nullableOperators.includes(select.value)) {
                input.disabled = true;
                input.value = '';
            } else {
                input.disabled = false;
            }
        } else {
            console.error('Cannot locate input: value');
        }
    }
}

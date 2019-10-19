import { Controller } from 'stimulus';

export default class extends Controller {
    /**
     * Updates the toggled status.
     *
     * @param {Event} event
     */
    update(event) {
        let enabled = event.target.checked;

        axios.post(this.data.get('url'), {
            _method: 'patch',
            enabled: enabled
        }).catch(() => {
            event.target.checked = false;
        })
    }
}

import toaster from "../toaster";
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
        }).then(() => {
            if (enabled && this.data.has('message-enabled')) {
                toaster.fire('success', this.data.get('message-enabled'));
            } else if (!enabled && this.data.has('message-disabled')) {
                toaster.fire('success', this.data.get('message-disabled'));
            }
        }).catch(() => {
            event.target.checked = false;
        })
    }
}

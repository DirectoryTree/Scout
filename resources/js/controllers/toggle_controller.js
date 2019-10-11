import toaster from '../toaster';
import { Controller } from 'stimulus';

export default class extends Controller {
    send(event) {
        let enabled = event.target.checked;

        axios.post(this.data.get('url'), {
            _method: 'patch',
            enabled: enabled
        }).then(() => {
            let message = enabled ? 'Enabled notifier' : 'Disabled notifier';

            toaster.fire('success', 'Saved', message);
        })
    }
}

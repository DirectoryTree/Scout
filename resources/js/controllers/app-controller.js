import { Controller } from 'stimulus';

export default class extends Controller {
    static targets = ['modal'];

    initialize() {
        this.keepAlive();
    }

    /**
     * Open the global application modal.
     *
     * @param {Object} event
     */
    openModal(event) {
        event.preventDefault();

        let modalController = this.application.getControllerForElementAndIdentifier(
            this.modalTarget,
            "modal"
        );

        modalController.load(event.target.dataset.url).then(() => {
            modalController.open();
        });
    }

    /**
     * Keep the users session alive.
     */
    keepAlive() {
        let lifetimeInMinutes = this.data.get('session-lifetime-minutes') - 1;

        setInterval(() => {
            axios.get(this.data.get('ping-url'));
        }, lifetimeInMinutes * 60000);
    }
}

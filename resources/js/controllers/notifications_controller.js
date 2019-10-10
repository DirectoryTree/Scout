import { Controller } from "stimulus"
import { NativeEventSource, EventSourcePolyfill } from 'event-source-polyfill';

const EventSource = NativeEventSource || EventSourcePolyfill;

export default class extends Controller {
    static targets = ['count', 'notification', 'list'];

    eventSource = null;
    eventSourceTimeout = null;

    /**
     * Update the notification count and set the event source timeout.
     */
    connect() {
        this.updateCount();

        // Initiate the setup after a time period to
        // prevent constant event source creations
        // on every page navigation.
        this.eventSourceTimeout = setTimeout(() => {
            this.setup();
        }, 5000);
    }

    /**
     * Clear the timeout and close any open event sources.
     */
    disconnect() {
        clearTimeout(this.eventSourceTimeout);

        // If the event source was setup, we'll
        // close it out before disconnecting.
        if (this.eventSource) {
            this.eventSource.close();
        }
    }

    /**
     * Setup the notification event source.
     */
    setup() {
        this.eventSource = new EventSource(this.data.get('url'));

        this.eventSource.addEventListener('message', (event) => {
            let notifications = '';

            JSON.parse(event.data).forEach((notification) => {
                notifications += notification;
            });

            this.listTarget.innerHTML = notifications;

            this.updateCount();
        }, false);

        this.eventSource.addEventListener('error', event => {
            if (event.readyState === EventSource.CLOSED) {
                console.log('EventSource was closed');
                console.log(EventSource);
            }
        }, false);
    }

    /**
     * Update the notification count.
     */
    updateCount() {
        let count = this.notificationTargets.length;

        if (count > 0) {
            this.countTarget.classList = ['badge badge-primary'];
        } else {
            this.countTarget.classList = ['badge badge-secondary'];
        }

        // Set the total number of notifications.
        this.countTarget.innerHTML = count;
    }
}

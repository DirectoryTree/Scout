import { Controller } from "stimulus"
import { NativeEventSource, EventSourcePolyfill } from 'event-source-polyfill';

const EventSource = NativeEventSource || EventSourcePolyfill;

export default class extends Controller {
    static targets = ['count', 'notification', 'list'];

    static eventSource;

    connect() {
        this.updateCount();
        
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

    disconnect() {
        this.eventSource.close();
    }

    updateCount() {
        // Set the total number of notifications.
        this.countTarget.innerHTML = this.notificationTargets.length;
    }
}

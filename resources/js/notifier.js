import { NativeEventSource, EventSourcePolyfill } from 'event-source-polyfill';

const EventSource = NativeEventSource || EventSourcePolyfill;

class Notifier {
    constructor() {
        this.eventSource = null;
        this.notifications = [];
        this.closure = null;
    };

    /**
     * Initialize the notification event source.
     *
     * @param {String} url
     */
    init(url) {
        this.eventSource = new EventSource(url);

        this.eventSource.addEventListener('message', (event) => {
            this.notifications = JSON.parse(event.data);

            if (this.closure) {
                this.closure(this.notifications);
            }
        }, false);

        this.eventSource.addEventListener('error', event => {
            if (event.readyState === EventSource.CLOSED) {
                console.log('EventSource was closed');
                console.log(EventSource);
            }
        }, false);
    };

    /**
     * The closure to execute when a sever message arrives.
     *
     * @param {function} closure
     */
    onMessage(closure) {
        this.closure = closure;
    };
}

export default Notifier;

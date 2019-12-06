import { Controller } from 'stimulus';

export default class extends Controller {
    connect() {
        if (this.data.has("needed")) {
            this.startPolling();
        }
    }

    disconnect() {
        this.stopPolling();
    }

    load() {
        fetch(this.data.get("url"))
            .then(response => response.text())
            .then(html => {
                this.element.outerHTML = html
            });
    }

    startPolling() {
        this.refreshTimer = setInterval(() => {
            this.load()
        }, this.data.get("interval"));
    }

    stopPolling() {
        if (this.refreshTimer) {
            clearInterval(this.refreshTimer);
        }
    }
}

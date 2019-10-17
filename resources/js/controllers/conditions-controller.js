import HiddenController from './hidden-controller';

export default class extends HiddenController {
    connect() {
        this.alert = document.getElementById('alert-no-notifiers');
    }

    open() {
        super.open();

        this.alert.classList.add('d-none');
    }

    close() {
        super.close();

        this.alert.classList.remove('d-none');
    }
}

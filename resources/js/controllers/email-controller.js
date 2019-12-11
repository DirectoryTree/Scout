import { Controller } from 'stimulus';

export default class extends Controller {
    static targets = ['selector', 'driver'];

    hideClass = 'd-none';

    initialize() {
        this.hideDrivers();

        this.toggle(this.selectorTarget.value);

        this.selectorTarget.addEventListener('change', (event) => {
            this.hideDrivers();

            this.toggle(event.target.value);
        });
    }

    /**
     * Toggle the driver input container.
     *
     * @param {String} driverName
     */
    toggle(driverName) {
        let driver = this.driverTargets.find(div => div.dataset.type === driverName);

        if (driver) {
            this.containerIsClosed(driver) ? this.open(driver) : this.close(driver);
        }
    }

    /**
     * Hide all driver input containers.
     */
    hideDrivers() {
        this.driverTargets.forEach((driver) => {
            this.close(driver);
        })
    }

    /**
     * Determine if the driver is closed.
     *
     * @param {Object} driver
     *
     * @returns {boolean}
     */
    containerIsClosed(driver) {
        return driver.classList.contains(this.hideClass);
    }

    /**
     * Open the driver container.
     *
     * @param {Object} driver
     */
    open(driver) {
        driver.classList.remove(this.hideClass);
    }

    /**
     * Close the driver container.
     *
     * @param {Object} driver
     */
    close(driver) {
        driver.classList.add(this.hideClass);
    }
}

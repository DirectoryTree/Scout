import FormController from './form-controller';

export default class extends FormController {
    /**
     * Show the shrink button once loading has completed.
     */
    done() {
        this.hideExpandButton();
        this.showShrinkButton();
    }

    /**
     * Remove the object leaves.
     *
     * We won't cache the leaves content to allow
     * refreshing them via a shrink and expand.
     */
    shrink() {
        this.showExpandButton();
        this.hideShrinkButton();

        this.getLeavesContainer().innerHTML = null;
    }

    /**
     * Show the tree expand button.
     */
    showExpandButton() {
        this.getExpandButton().classList.remove('d-none');
    }

    /**
     * Hide the tree expand button.
     */
    hideExpandButton() {
        this.getExpandButton().classList.add('d-none');
    }

    /**
     * Show the tree shrink button.
     */
    showShrinkButton() {
        this.getShrinkButton().classList.remove('d-none');
    }

    /**
     * Hide the tree shrink button.
     */
    hideShrinkButton() {
        this.getShrinkButton().classList.add('d-none');
    }

    /**
     * Get the expand button.
     *
     * @returns {HTMLElement}
     */
    getExpandButton() {
        return document.getElementById('btn_expand_' + this.getObjectId());
    }

    /**
     * Get the shrink button.
     *
     * @returns {HTMLElement}
     */
    getShrinkButton() {
        return document.getElementById('btn_shrink_' + this.getObjectId());
    }

    /**
     * Get the container containing the objects leaves.
     *
     * @returns {HTMLElement}
     */
    getLeavesContainer() {
        return document.getElementById('leaves_' + this.getObjectId());
    }

    /**
     * Get the object ID.
     *
     * @returns {string}
     */
    getObjectId() {
        return this.data.get('id');
    }
}

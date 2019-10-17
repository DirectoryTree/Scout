import { Controller } from "stimulus";

export default class extends Controller {
    static targets = ['title', 'body'];

    /**
     * Set the title of the modal.
     *
     * @param {String} content
     */
    setTitle(content) {
        this.titleTarget.innerHTML = content;
    }

    /**
     * Set the body of the modal.
     *
     * @param {String} content
     */
    setBody(content) {
        this.bodyTarget.innerHTML = content;
    }

    /**
     * Open the modal.
     */
    open() {
        document.body.classList.add("modal-open");
        this.element.setAttribute("style", "display: block;");
        this.element.classList.add("show");
        document.body.innerHTML += '<div id="modal-backdrop" class="modal-backdrop fade show"></div>';
    }

    /**
     * Close the modal.
     */
    close() {
        document.body.classList.remove("modal-open");
        this.element.removeAttribute("style");
        this.element.classList.remove("show");
        document.getElementsByClassName("modal-backdrop")[0].remove();
    }
}

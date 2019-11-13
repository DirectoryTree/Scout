
import * as Ladda from 'ladda';

export default class {
    /**
     * Binds the Ladda loading indicators.
     */
    static bind() {
        Ladda.bind('button[type=submit]:not(.no-loading)');
    }

    /**
     * Stops all Ladda loading indicators.
     */
    static stopAll() {
        Ladda.stopAll();
    }
}

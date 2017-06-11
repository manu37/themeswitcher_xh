/*!
 * Themeswitcher_XH
 *
 * @copyright 2015-2017 Christoph M. Becker <http://3-magi.net/>
 * @license   GNU GPL <http://www.gnu.org/licenses/gpl-3.0.en.html>
 */

/*jslint browser: true, maxlen: 80 */

(function () {
    "use strict";

    /**
     * Calls a callback for each element.
     *
     * @param   {array-like} element
     * @param   {Function}   callback
     * @returns {undefined}
     */
    function forEach(objects, callback) {
        var i, n;

        for (i = 0, n = objects.length; i < n; i += 1) {
            callback(objects[i]);
        }
    }

    /**
     * Registers an event listener.
     *
     * @param   {Object}    object
     * @param   {string}    event
     * @param   {Function}  listener
     * @returns {undefined}
     */
    function on(object, event, listener) {
        if (typeof object.addEventListener !== "undefined") {
            object.addEventListener(event, listener, false);
        } else if (typeof object.attachEvent !== "undefined") {
            object.attachEvent("on" + event, listener);
        }
    }

    /**
     * Initializes the themeswitcher select forms.
     *
     * @returns {undefined}
     */
    function initForms() {
        forEach(document.forms, function (form) {
            if (form.className === "themeswitcher_select_form") {
                on(form.themeswitcher_select, "change", function (event) {
                    var target = event.target || event.srcElement;

                    target.form.submit();
                });
                form.getElementsByTagName("button")[0].style.display = "none";
            }
        });
    }

    on(window, "load", initForms);
}());

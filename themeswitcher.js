/**
 * Copyright (C) 2015-2017 Christoph M. Becker
 *
 * This file is part of Themeswitcher_XH.
 *
 * Themeswitcher_XH is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Themeswitcher_XH is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Themeswitcher_XH.  If not, see <http://www.gnu.org/licenses/>.
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

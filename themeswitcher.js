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

(function () {
    "use strict";

    if (!("visibilityState" in document)) {
        return;
    }

    var each = Array.prototype.forEach;

    document.addEventListener("DOMContentLoaded", function () {
        each.call(document.getElementsByClassName("themeswitcher_select_form"), function (form) {
            form.themeswitcher_select.addEventListener("change", function () {
                this.form.submit();
            });
            each.call(form.getElementsByTagName("button"), function (button) {
                button.style.display = "none";
            });
        });
    });
}());

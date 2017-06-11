<?php

/**
 * Copyright (C) 2014-2017 Christoph M. Becker
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

/*
 * Prevent direct access and usage from unsupported CMSimple_XH versions.
 */
if (!defined('CMSIMPLE_XH_VERSION')
    || strpos(CMSIMPLE_XH_VERSION, 'CMSimple_XH') !== 0
    || version_compare(CMSIMPLE_XH_VERSION, 'CMSimple_XH 1.6', 'lt')
) {
    header('HTTP/1.1 403 Forbidden');
    header('Content-Type: text/plain; charset=UTF-8');
    die(<<<EOT
Themeswitcher_XH detected an unsupported CMSimple_XH version.
Uninstall Themeswitcher_XH or upgrade to a supported CMSimple_XH version!
EOT
    );
}

/**
 * The plugin version.
 */
define('THEMESWITCHER_VERSION', '@THEMESWITCHER_VERSION@');

/**
 * @return string
 */
function themeswitcher()
{
    global $_Themeswitcher_controller;

    return $_Themeswitcher_controller->renderThemeSelection();
}

/**
 * @var Themeswitcher\Controller
 */
$_Themeswitcher_controller = new Themeswitcher\Controller(
    new Themeswitcher\CommandFactory()
);
$_Themeswitcher_controller->dispatch();

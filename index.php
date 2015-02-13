<?php

/**
 * The plugin entry point.
 *
 * PHP version 5
 *
 * @category  CMSimple_XH
 * @package   Themeswitcher
 * @author    Christoph M. Becker <cmbecker69@gmx.de>
 * @copyright 2014-2015 Christoph M. Becker <http://3-magi.net>
 * @license   http://www.gnu.org/licenses/gpl-3.0.en.html GNU GPLv3
 * @link      http://3-magi.net/?CMSimple_XH/Themeswitcher_XH
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
 * Renders the theme selection form.
 *
 * @return string (X)HTML.
 *
 * @global Themeswitcher_Controller The controller.
 */
function themeswitcher()
{
    global $_Themeswitcher_controller;

    return $_Themeswitcher_controller->renderThemeSelection();
}

/**
 * The controller.
 *
 * @var Themeswitcher_Controller
 */
$_Themeswitcher_controller = new Themeswitcher_Controller(
    new Themeswitcher_CommandFactory()
);
$_Themeswitcher_controller->dispatch();

?>

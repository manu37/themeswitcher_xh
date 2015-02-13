<?php

/**
 * main ;)
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
 * Prevent direct access.
 */
if (!defined('CMSIMPLE_XH_VERSION')) {
    header('HTTP/1.0 403 Forbidden');
    exit;
}

/**
 * The domain layer.
 */
require_once $pth['folder']['plugin_classes'] . 'Domain.php';

/**
 * The presentation layer.
 */
require_once $pth['folder']['plugin_classes'] . 'Presentation.php';

/**
 * The plugin version.
 */
define('THEMESWITCHER_VERSION', '@THEMESWITCHER_VERSION@');

/**
 * Renders the theme selection.
 *
 * @return string (X)HTML.
 *
 * @global Themeswitcher_Controller The controller.
 */
function Themeswitcher_selection()
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

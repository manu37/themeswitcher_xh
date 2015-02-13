<?php

/**
 * The autoloader.
 *
 * PHP version 5
 *
 * @category  CMSimple_XH
 * @package   Themeswitcher
 * @author    Christoph M. Becker <cmbecker69@gmx.de>
 * @copyright 2014-2015 Christoph M. Becker <http://3-magi.net/>
 * @license   http://www.gnu.org/licenses/gpl-3.0.en.html GNU GPLv3
 * @link      http://3-magi.net/?CMSimple_XH/Themeswitcher_XH
 */

spl_autoload_register('Themeswitcher_autoload');

/**
 * The autoloader.
 *
 * @param string $className A class name.
 *
 * @return void
 *
 * @global array The paths of system files and folders.
 */
function Themeswitcher_autoload($className)
{
    global $pth;

    $parts = explode('_', $className);
    if ($parts[0] == 'Themeswitcher') {
        include_once $pth['folder']['plugins'] . 'themeswitcher/classes/'
            . $parts[1] . '.php';
    }
}

?>
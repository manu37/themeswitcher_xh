<?php

/**
 * The command factory.
 *
 * PHP version 5
 *
 * @category  CMSimple_XH
 * @package   Themeswitcher
 * @author    Christoph M. Becker <cmbecker69@gmx.de>
 * @copyright 2014-2017 Christoph M. Becker <http://3-magi.net>
 * @license   http://www.gnu.org/licenses/gpl-3.0.en.html GNU GPLv3
 * @link      http://3-magi.net/?CMSimple_XH/Themeswitcher_XH
 */

/**
 * The command factory.
 *
 * @category CMSimple_XH
 * @package  Themeswitcher
 * @author   Christoph M. Becker <cmbecker69@gmx.de>
 * @license  http://www.gnu.org/licenses/gpl-3.0.en.html GNU GPLv3
 * @link     http://3-magi.net/?CMSimple_XH/Themeswitcher_XH
 */
class Themeswitcher_CommandFactory
{
    /**
     * Makes a theme selection command.
     *
     * @return Themeswitcher_ThemeSelectionCommand
     */
    public function makeThemeSelectionCommand()
    {
        return new Themeswitcher_ThemeSelectionCommand(
            new Themeswitcher_Model()
        );
    }

    /**
     * Makes a select theme command.
     *
     * @return Themeswitcher_SelectThemeCommand
     */
    public function makeSelectThemeCommand()
    {
        return new Themeswitcher_SelectThemeCommand(
            new Themeswitcher_Model()
        );
    }

    /**
     * Makes an info command.
     *
     * @return Themeswitcher_InfoCommand
     */
    public function makeInfoCommand()
    {
        return new Themeswitcher_InfoCommand();
    }
}

?>

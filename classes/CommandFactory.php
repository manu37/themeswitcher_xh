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

namespace Themeswitcher;

/**
 * The command factory.
 *
 * @category CMSimple_XH
 * @package  Themeswitcher
 * @author   Christoph M. Becker <cmbecker69@gmx.de>
 * @license  http://www.gnu.org/licenses/gpl-3.0.en.html GNU GPLv3
 * @link     http://3-magi.net/?CMSimple_XH/Themeswitcher_XH
 */
class CommandFactory
{
    /**
     * Makes a theme selection command.
     *
     * @return ThemeSelectionCommand
     */
    public function makeThemeSelectionCommand()
    {
        return new ThemeSelectionCommand(
            new Model()
        );
    }

    /**
     * Makes a select theme command.
     *
     * @return SelectThemeCommand
     */
    public function makeSelectThemeCommand()
    {
        return new SelectThemeCommand(
            new Model()
        );
    }

    /**
     * Makes an info command.
     *
     * @return InfoCommand
     */
    public function makeInfoCommand()
    {
        return new InfoCommand();
    }
}

?>

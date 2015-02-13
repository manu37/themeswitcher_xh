<?php

/**
 * The controller.
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

/**
 * The controller.
 *
 * @category CMSimple_XH
 * @package  Themeswitcher
 * @author   Christoph M. Becker <cmbecker69@gmx.de>
 * @license  http://www.gnu.org/licenses/gpl-3.0.en.html GNU GPLv3
 * @link     http://3-magi.net/?CMSimple_XH/Themeswitcher_XH
 */
class Themeswitcher_Controller
{
    /**
     * The command factory.
     *
     * @var Themeswitcher_CommandFactory.
     */
    private $_commandFactory;

    /**
     * Initializes a new instance.
     *
     * @param Themeswitcher_CommandFactory $commandFactory A command factory.
     *
     * @return void
     */
    public function __construct(Themeswitcher_CommandFactory $commandFactory)
    {
        $this->_commandFactory = $commandFactory;
    }

    /**
     * Dispatches according to the request.
     *
     * @return void
     */
    public function dispatch()
    {
        if (isset($_GET['themeswitcher_select'])
            || isset($_COOKIE['themeswitcher_theme'])
        ) {
            $this->_commandFactory->makeSelectThemeCommand()->execute();
        }
        if ($this->_isPluginAdministration()) {
            $this->_handleAdministration();
        }
    }

    /**
     * Whether the plugin administration is requested.
     *
     * @return bool
     *
     * @global string Whether the plugin is requested.
     */
    private function _isPluginAdministration()
    {
        global $themeswitcher;

        return XH_ADM && isset($themeswitcher) && $themeswitcher == 'true';
    }

    /**
     * Handles the plugin administration.
     *
     * @return void
     *
     * @global string The value of the <var>admin</var> GP parameter.
     * @global string The value of the <var>action</var> GP parameter.
     * @global string The output for the content area.
     */
    private function _handleAdministration()
    {
        global $admin, $action, $o;

        $o .= print_plugin_admin('off');
        switch ($admin) {
        case '':
            $o .= $this->_commandFactory->makeInfoCommand()->render();
            break;
        default:
            $o .= plugin_admin_common($admin, $action, 'themeswitcher');
        }
    }

    /**
     * Renders the theme selection.
     *
     * @return string (X)HTML.
     */
    public function renderThemeSelection()
    {
        return $this->_commandFactory->makeThemeSelectionCommand()->render();
    }
}

?>

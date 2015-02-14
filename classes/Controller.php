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
    protected $commandFactory;

    /**
     * Initializes a new instance.
     *
     * @param Themeswitcher_CommandFactory $commandFactory A command factory.
     *
     * @return void
     */
    public function __construct(Themeswitcher_CommandFactory $commandFactory)
    {
        $this->commandFactory = $commandFactory;
    }

    /**
     * Dispatches according to the request.
     *
     * @return void
     */
    public function dispatch()
    {
        if (isset($_POST['themeswitcher_select'])
            || isset($_COOKIE['themeswitcher_theme'])
        ) {
            $this->commandFactory->makeSelectThemeCommand()->execute();
        }
        if ($this->isAutomatic()) {
            $this->outputContents($this->renderThemeSelection());
        }
        if (XH_ADM) {
            if (function_exists('XH_registerStandardPluginMenuItems')) {
                XH_registerStandardPluginMenuItems(false);
            }
            if ($this->isAdministrationRequested()) {
                $this->handleAdministration();
            }
        }
    }

    /**
     * Whether the theme selection is displayed automatically.
     *
     * @return bool
     *
     * @global bool  Whether the print view is requested.
     * @global bool  Whether we're in edit mode.
     * @global array The configuration of the plugins.
     */
    protected function isAutomatic()
    {
        global $print, $edit, $plugin_cf;

        $mode = $plugin_cf['themeswitcher']['display_automatic'];
        return ($mode == 'always' || $mode == 'frontend' && !$edit)
            && !$print;
    }

    /**
     * Outputs (X)HTML to the contents area.
     *
     * @param string $html Some (X)HTML.
     *
     * @return void
     *     *
     * @global string The (X)HTML of the contents area.
     */
    protected function outputContents($html)
    {
        global $o;

        $o .= $html;
    }

    /**
     * Whether the plugin administration is requested.
     *
     * @return bool
     *
     * @global string Whether the plugin is requested.
     */
    protected function isAdministrationRequested()
    {
        global $themeswitcher;

        return function_exists('XH_wantsPluginAdministration')
            && XH_wantsPluginAdministration('themeswitcher')
            || isset($themeswitcher) && $themeswitcher == 'true';
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
    protected function handleAdministration()
    {
        global $admin, $action, $o;

        $o .= print_plugin_admin('off');
        switch ($admin) {
        case '':
            $o .= $this->commandFactory->makeInfoCommand()->render();
            break;
        default:
            $o .= plugin_admin_common($action, $admin, 'themeswitcher');
        }
    }

    /**
     * Renders the theme selection.
     *
     * @return string (X)HTML.
     */
    public function renderThemeSelection()
    {
        return $this->commandFactory->makeThemeSelectionCommand()->render();
    }
}

?>

<?php

/**
 * The presentation layer.
 *
 * PHP version 5
 *
 * @category  CMSimple_XH
 * @package   Themeswitcher
 * @author    Christoph M. Becker <cmbecker69@gmx.de>
 * @copyright 2014 Christoph M. Becker <http://3-magi.net>
 * @license   http://www.gnu.org/licenses/gpl-3.0.en.html GNU GPLv3
 * @version   SVN: $Id$
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
}

/**
 * The theme selection command.
 *
 * @category CMSimple_XH
 * @package  Themeswitcher
 * @author   Christoph M. Becker <cmbecker69@gmx.de>
 * @license  http://www.gnu.org/licenses/gpl-3.0.en.html GNU GPLv3
 * @link     http://3-magi.net/?CMSimple_XH/Themeswitcher_XH
 */
class Themeswitcher_ThemeSelectionCommand
{
    /**
     * The model.
     *
     * @var Themeswitcher_Model
     */
    private $_model;

    /**
     * The script name
     *
     * @var string
     */
    private $_scriptName;

    /**
     * The selected URL.
     *
     * @var string
     */
    private $_selectedUrl;

    /**
     * Initializes a new instance.
     *
     * @param Themeswitcher_Model $model A model.
     *
     * @return void
     *
     * @global string The script name.
     * @global string The selected URL.
     */
    public function __construct(Themeswitcher_Model $model)
    {
        global $sn, $su;

        $this->_model = $model;
        $this->_scriptName = (string) $sn;
        $this->_selectedUrl = (string) $su;
    }

    /**
     * Renders the view.
     *
     * @return string (X)HTML.
     */
    public function render()
    {
        return '<form class="themeswitcher_select_form" action="'
            . XH_hsc($this->_scriptName) . '" method="get">'
            . $this->_renderSelectedInput()
            . $this->_renderSelect()
            . $this->_renderSubmitButton()
            . '</form>';
    }

    /**
     * Renders the selected input element.
     *
     * @return string (X)HTML.
     */
    private function _renderSelectedInput()
    {
        return tag(
            'input type="hidden" name="selected" value="'
            . XH_hsc($this->_selectedUrl) . '"'
        );
    }

    /**
     * Renders the select element.
     *
     * @return string (X)HTML.
     */
    private function _renderSelect()
    {
        $result = '<select name="themeswitcher_select">';
        foreach ($this->_model->getThemes() as $theme) {
            $result .= $this->_renderOption($theme);
        }
        $result .= '</select>';
        return $result;
    }

    /**
     * Renders an option element.
     *
     * @param string $theme A theme name.
     *
     * @return string (X)HTML.
     */
    private function _renderOption($theme)
    {
        $theme = XH_hsc($theme);
        return tag('option label="' . $theme . '" value="' . $theme . '"');
    }

    /**
     * Renders a submit button.
     *
     * @return string (X)HTML.
     *
     * @global array The localization of the plugins.
     */
    private function _renderSubmitButton()
    {
        global $plugin_tx;

        return '<button>' . $plugin_tx['themeswitcher']['label_activate']
            . '</button>';
    }
}

/**
 * The select theme command.
 *
 * @category CMSimple_XH
 * @package  Themeswitcher
 * @author   Christoph M. Becker <cmbecker69@gmx.de>
 * @license  http://www.gnu.org/licenses/gpl-3.0.en.html GNU GPLv3
 * @link     http://3-magi.net/?CMSimple_XH/Themeswitcher_XH
 */
class Themeswitcher_SelectThemeCommand
{
    /**
     * The model.
     *
     * @var Themeswitcher_Model
     */
    private $_model;

    /**
     * Initializes a new instance.
     *
     * @param Themeswitcher_Model $model A model.
     *
     * @return void
     */
    public function __construct(Themeswitcher_Model $model)
    {
        $this->_model = $model;
    }

    /**
     * Executes the command.
     *
     * @return void
     */
    public function execute()
    {
        if ($this->_isUserThemeAllowed()) {
            $this->_model->switchTheme($this->_getUserTheme());
            $this->_setThemeCookie();
        }
    }

    /**
     * Returns the theme selected by the user.
     *
     * @return string
     */
    private function _getUserTheme()
    {
        if (isset($_GET['themeswitcher_select'])) {
            return stsl($_GET['themeswitcher_select']);
        } else {
            return stsl($_COOKIE['themeswitcher_theme']);
        }
    }

    /**
     * Returns whether the user selected theme is allowed.
     *
     * @return bool
     */
    private function _isUserThemeAllowed()
    {
        return in_array($this->_getUserTheme(), $this->_model->getThemes());
    }

    /**
     * Sets the theme cookie if necessary.
     *
     * @return void
     */
    private function _setThemeCookie()
    {
        if (isset($_GET['themeswitcher_select'])) {
            setcookie(
                'themeswitcher_theme', $this->_getUserTheme(),
                0, CMSIMPLE_ROOT
            );
        }
    }
}

?>

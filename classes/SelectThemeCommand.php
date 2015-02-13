<?php

/**
 * The select theme command.
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
        if ($this->_isUserThemeAllowed()
            && (!$this->_hasPageTheme() || !$this->_isPageThemePreferred())
        ) {
            $this->_model->switchTheme($this->_getUserTheme());
            $this->_setThemeCookie();
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
     * Returns hether the selected page has an individual theme.
     *
     * @return bool
     *
     * @global array The page data of the selected page.
     */
    private function _hasPageTheme()
    {
        global $pd_current;

        return $pd_current['template'] != '';
    }

    /**
     * Returns whether individual page themes are preferred.
     *
     * @return bool
     *
     * @global array The configuration of the plugins.
     */
    private function _isPageThemePreferred()
    {
        global $plugin_cf;

        return (bool) $plugin_cf['themeswitcher']['prefer_page_theme'];
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

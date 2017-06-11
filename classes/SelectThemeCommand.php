<?php

/**
 * The select theme command.
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
 * The select theme command.
 *
 * @category CMSimple_XH
 * @package  Themeswitcher
 * @author   Christoph M. Becker <cmbecker69@gmx.de>
 * @license  http://www.gnu.org/licenses/gpl-3.0.en.html GNU GPLv3
 * @link     http://3-magi.net/?CMSimple_XH/Themeswitcher_XH
 */
class SelectThemeCommand
{
    /**
     * The model.
     *
     * @var Model
     */
    protected $model;

    /**
     * Initializes a new instance.
     *
     * @param Model $model A model.
     *
     * @return void
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Executes the command.
     *
     * @return void
     */
    public function execute()
    {
        if ($this->isUserThemeAllowed()
            && (!$this->hasPageTheme() || !$this->isPageThemePreferred())
        ) {
            $this->model->switchTheme($this->getUserTheme());
            $this->setThemeCookie();
        }
    }

    /**
     * Returns whether the user selected theme is allowed.
     *
     * @return bool
     */
    protected function isUserThemeAllowed()
    {
        return in_array($this->getUserTheme(), $this->model->getThemes());
    }

    /**
     * Returns hether the selected page has an individual theme.
     *
     * @return bool
     *
     * @global array The page data of the selected page.
     */
    protected function hasPageTheme()
    {
        global $pd_current;

        return !empty($pd_current['template']);
    }

    /**
     * Returns whether individual page themes are preferred.
     *
     * @return bool
     *
     * @global array The configuration of the plugins.
     */
    protected function isPageThemePreferred()
    {
        global $plugin_cf;

        return (bool) $plugin_cf['themeswitcher']['prefer_page_theme'];
    }

    /**
     * Returns the theme selected by the user.
     *
     * @return string
     */
    protected function getUserTheme()
    {
        if (isset($_POST['themeswitcher_select'])) {
            return stsl($_POST['themeswitcher_select']);
        } else {
            return stsl($_COOKIE['themeswitcher_theme']);
        }
    }

    /**
     * Sets the theme cookie if necessary.
     *
     * @return void
     */
    protected function setThemeCookie()
    {
        if (isset($_POST['themeswitcher_select'])) {
            setcookie(
                'themeswitcher_theme', $this->getUserTheme(),
                0, CMSIMPLE_ROOT
            );
        }
    }
}

?>

<?php

/**
 * Copyright (C) 2014-2017 Christoph M. Becker
 *
 * This file is part of Themeswitcher_XH.
 *
 * Themeswitcher_XH is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Themeswitcher_XH is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Themeswitcher_XH.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Themeswitcher;

class SelectThemeCommand
{
    /**
     * @var Model
     */
    private $model;

    /**
     * @return void
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
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
     * @return bool
     */
    private function isUserThemeAllowed()
    {
        return in_array($this->getUserTheme(), $this->model->getThemes());
    }

    /**
     * @return bool
     */
    private function hasPageTheme()
    {
        global $pd_current;

        return !empty($pd_current['template']);
    }

    /**
     * @return bool
     */
    private function isPageThemePreferred()
    {
        global $plugin_cf;

        return (bool) $plugin_cf['themeswitcher']['prefer_page_theme'];
    }

    /**
     * @return string
     */
    private function getUserTheme()
    {
        if (isset($_GET['themeswitcher_select'])) {
            return $_GET['themeswitcher_select'];
        } else {
            return $_COOKIE['themeswitcher_theme'];
        }
    }

    /**
     * @return void
     */
    private function setThemeCookie()
    {
        if (isset($_GET['themeswitcher_select'])) {
            setcookie('themeswitcher_theme', $this->getUserTheme(), 0, CMSIMPLE_ROOT);
        }
    }
}

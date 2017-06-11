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

class Model
{
    /**
     * @return string[]
     */
    public function getThemes()
    {
        $themes = [];
        foreach (XH_templates() as $theme) {
            if ($this->isThemeAllowed($theme)) {
                $themes[] = $theme;
            }
        }
        return $themes;
    }

    /**
     * @param string $theme
     * @return bool
     */
    private function isThemeAllowed($theme)
    {
        global $plugin_cf;

        $allowedThemes = explode(',', $plugin_cf['themeswitcher']['allowed_themes']);
        foreach ($allowedThemes as $allowedTheme) {
            if ($this->fnmatch($allowedTheme, $theme)) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param string $pattern
     * @param string $string
     * @return bool
     */
    private function fnmatch($pattern, $string)
    {
        $pattern = strtr(
            preg_quote($pattern, '/'),
            array(
                '\*' => '.*',
                '\?' => '.'
            )
        );
        return (bool) preg_match("/^{$pattern}$/", $string);
    }

    /**
     * @param string $theme
     * @return void
     */
    public function switchTheme($theme)
    {
        global $pth;

        $pth['folder']['template'] = $pth['folder']['templates'] . $theme . '/';
        $pth['file']['template'] = $pth['folder']['template'] . 'template.htm';
        $pth['file']['stylesheet'] = $pth['folder']['template'] . 'stylesheet.css';
        $pth['folder']['menubuttons'] = $pth['folder']['template'] . 'menu/';
        $pth['folder']['templateimages'] = $pth['folder']['template'] . 'images/';
    }
}

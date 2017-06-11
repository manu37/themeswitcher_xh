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

class ThemeSelectionCommand
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
     * @return string
     */
    public function render()
    {
        global $pth, $bjs, $plugin_tx;
        static $run = 0;

        $run++;
        $bjs .= '<script type="text/javascript" src="' . $pth['folder']['plugins']
            . 'themeswitcher/themeswitcher.js"></script>';
        return '<form class="themeswitcher_select_form" method="post">'
            . '<label for="themeswitcher_' . $run . '">'
            . $plugin_tx['themeswitcher']['label_theme'] . '</label>'
            . $this->renderSelect($run)
            . $this->renderSubmitButton()
            . '</form>';
    }

    /**
     * @param int $run
     * @return string
     */
    private function renderSelect($run)
    {
        $html = '<select id="themeswitcher_' . $run
            . '" name="themeswitcher_select">';
        foreach ($this->model->getThemes() as $theme) {
            $html .= $this->renderOption($theme);
        }
        $html .= '</select>';
        return $html;
    }

    /**
     * @param string $theme
     * @return string
     */
    private function renderOption($theme)
    {
        $html = '<option value="' . XH_hsc($theme) . '"';
        if ($theme == $this->getCurrentTheme()) {
            $html .= ' selected="selected"';
        }
        $html .= '>' . XH_hsc($theme) . '</option>';
        return $html;
    }

    /**
     * @return string
     */
    private function renderSubmitButton()
    {
        global $plugin_tx;

        return '<button>' . $plugin_tx['themeswitcher']['label_activate']
            . '</button>';
    }

    /**
     * @return string
     */
    private function getCurrentTheme()
    {
        global $cf;

        if (isset($_POST['themeswitcher_select'])) {
            return stsl($_POST['themeswitcher_select']);
        } elseif (isset($_COOKIE['themeswitcher_theme'])) {
            return stsl($_COOKIE['themeswitcher_theme']);
        } else {
            return $cf['site']['template'];
        }
    }
}

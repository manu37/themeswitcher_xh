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

class Controller
{
    /**
     * @var CommandFactory
     */
    private $commandFactory;

    /**
     * @return void
     */
    public function __construct(CommandFactory $commandFactory)
    {
        $this->commandFactory = $commandFactory;
    }

    /**
     * @return void
     */
    public function dispatch()
    {
        if (isset($_GET['themeswitcher_select'])
            || isset($_COOKIE['themeswitcher_theme'])
        ) {
            $this->commandFactory->makeSelectThemeCommand()->execute();
        }
        if ($this->isAutomatic()) {
            $this->outputContents($this->renderThemeSelection());
        }
        if (XH_ADM) {
            XH_registerStandardPluginMenuItems(false);
            if ($this->isAdministrationRequested()) {
                $this->handleAdministration();
            }
        }
    }

    /**
     * @return bool
     */
    private function isAutomatic()
    {
        global $print, $edit, $plugin_cf;

        $mode = $plugin_cf['themeswitcher']['display_automatic'];
        return ($mode == 'always' || $mode == 'frontend' && !$edit)
            && !$print;
    }

    /**
     * @param string $html
     * @return void
     */
    private function outputContents($html)
    {
        global $o;

        $o .= $html;
    }

    /**
     * @return bool
     */
    private function isAdministrationRequested()
    {
        return XH_wantsPluginAdministration('themeswitcher');
    }

    /**
     * @return void
     */
    private function handleAdministration()
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
     * @return string
     */
    public function renderThemeSelection()
    {
        return $this->commandFactory->makeThemeSelectionCommand()->render();
    }
}

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

class InfoCommand
{
    /**
     * @return string
     */
    public function render()
    {
        return '<h1>Themeswitcher &ndash; Info</h1>'
            . $this->renderLogo()
            . '<p>Version: ' . THEMESWITCHER_VERSION . '</p>'
            . $this->renderCopyright() . $this->renderLicense();
    }

    /**
     * @return string
     */
    private function renderLogo()
    {
        global $pth, $plugin_tx;

        return tag(
            'img src="' . $pth['folder']['plugins']
            . 'themeswitcher/themeswitcher.png" class="themeswitcher_logo" alt="'
            . $plugin_tx['themeswitcher']['alt_logo'] . '"'
        );
    }

    /**
     * @return string
     */
    private function renderCopyright()
    {
        return '<p>Copyright &copy; 2014-2017 <a href="http://3-magi.net/">'
            . 'Christoph M. Becker</a></p>';
    }

    /**
     * @return string
     */
    private function renderLicense()
    {
        return <<<EOT
<p class="themeswitcher_license">Themeswitcher_XH is free software: you can
redistribute it and/or modify it under the terms of the GNU General Public
License as published by the Free Software Foundation, either version 3 of the
License, or (at your option) any later version.</p>
<p class="themeswitcher_license">Themeswitcher_XH is distributed in the hope that it
will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHAN&shy;TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General
Public License for more details.</p>
<p class="themeswitcher_license">You should have received a copy of the GNU
General Public License along with Themeswitcher_XH. If not, see <a
href="http://www.gnu.org/licenses/">http://www.gnu.org/licenses/</a>.</p>
EOT;
    }
}

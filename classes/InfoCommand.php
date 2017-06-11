<?php

/**
 * The info command.
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

/**
 * The info command.
 *
 * @category CMSimple_XH
 * @package  Themeswitcher
 * @author   Christoph M. Becker <cmbecker69@gmx.de>
 * @license  http://www.gnu.org/licenses/gpl-3.0.en.html GNU GPLv3
 * @link     http://3-magi.net/?CMSimple_XH/Themeswitcher_XH
 */
class Themeswitcher_InfoCommand
{
    /**
     * Renders the view.
     *
     * @return string (X)HTML.
     */
    public function render()
    {
        return '<h1>Themeswitcher &ndash; Info</h1>'
            . $this->renderLogo()
            . '<p>Version: ' . THEMESWITCHER_VERSION . '</p>'
            . $this->renderCopyright() . $this->renderLicense();
    }

    /**
     * Renders the plugin logo.
     *
     * @return string (X)HTML.
     *
     * @global array The paths of system files and folders.
     * @global array The localization of the plugins.
     */
    protected function renderLogo()
    {
        global $pth, $plugin_tx;

        return tag(
            'img src="' . $pth['folder']['plugins']
            . 'themeswitcher/themeswitcher.png" class="themeswitcher_logo" alt="'
            . $plugin_tx['themeswitcher']['alt_logo'] . '"'
        );
    }

    /**
     * Renders the copyright.
     *
     * @return string (X)HTML.
     */
    protected function renderCopyright()
    {
        return '<p>Copyright &copy; 2014-2017 <a href="http://3-magi.net/">'
            . 'Christoph M. Becker</a></p>';
    }

    /**
     * Renders the license.
     *
     * @return string (X)HTML.
     */
    protected function renderLicense()
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

?>

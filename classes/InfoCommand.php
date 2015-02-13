<?php

/**
 * The info command.
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
            . '<p>Version: ' . THEMESWITCHER_VERSION . '</p>'
            . $this->renderCopyright() . $this->renderLicense();
    }

    /**
     * Renders the copyright.
     *
     * @return string (X)HTML.
     */
    protected function renderCopyright()
    {
        return '<p>Copyright &copy; 2014-2015 <a href="http://3-magi.net/">'
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
<p class="themeswitcher_license">This program is free software: you can
redistribute it and/or modify it under the terms of the GNU General Public
License as published by the Free Software Foundation, either version 3 of the
License, or (at your option) any later version.</p>
<p class="themeswitcher_license">This program is distributed in the hope that it
will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHAN&shy;TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General
Public License for more details.</p>
<p class="themeswitcher_license">You should have received a copy of the GNU
General Public License along with this program. If not, see <a
href="http://www.gnu.org/licenses/">http://www.gnu.org/licenses/</a>.</p>
EOT;
    }
}

?>
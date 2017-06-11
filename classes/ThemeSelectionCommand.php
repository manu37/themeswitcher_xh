<?php

/**
 * The theme selection command.
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
 * The theme selection command.
 *
 * @category CMSimple_XH
 * @package  Themeswitcher
 * @author   Christoph M. Becker <cmbecker69@gmx.de>
 * @license  http://www.gnu.org/licenses/gpl-3.0.en.html GNU GPLv3
 * @link     http://3-magi.net/?CMSimple_XH/Themeswitcher_XH
 */
class ThemeSelectionCommand
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
     * Renders the view.
     *
     * @return string (X)HTML.
     *
     * @global array  The paths of system files and folders.
     * @global string The (X)HTML to insert before the closing body tag.
     * @global array  The localization of the plugins.
     *
     * @staticvar int The running number.
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
     * Renders the select element.
     *
     * @param int $run A running number.
     *
     * @return string (X)HTML.
     */
    protected function renderSelect($run)
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
     * Renders an option element.
     *
     * @param string $theme A theme name.
     *
     * @return string (X)HTML.
     */
    protected function renderOption($theme)
    {
        $html = '<option value="' . XH_hsc($theme) . '"';
        if ($theme == $this->getCurrentTheme()) {
            $html .= ' selected="selected"';
        }
        $html .= '>' . XH_hsc($theme) . '</option>';
        return $html;
    }

    /**
     * Renders a submit button.
     *
     * @return string (X)HTML.
     *
     * @global array The localization of the plugins.
     */
    protected function renderSubmitButton()
    {
        global $plugin_tx;

        return '<button>' . $plugin_tx['themeswitcher']['label_activate']
            . '</button>';
    }

    /**
     * Returns the current theme.
     *
     * @return string
     *
     * @global array The configuration of the core.
     */
    protected function getCurrentTheme()
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

?>

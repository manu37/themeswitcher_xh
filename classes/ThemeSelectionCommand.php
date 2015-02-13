<?php

/**
 * The theme selection command.
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
 * The theme selection command.
 *
 * @category CMSimple_XH
 * @package  Themeswitcher
 * @author   Christoph M. Becker <cmbecker69@gmx.de>
 * @license  http://www.gnu.org/licenses/gpl-3.0.en.html GNU GPLv3
 * @link     http://3-magi.net/?CMSimple_XH/Themeswitcher_XH
 */
class Themeswitcher_ThemeSelectionCommand
{
    /**
     * The model.
     *
     * @var Themeswitcher_Model
     */
    protected $model;

    /**
     * The script name
     *
     * @var string
     */
    protected $scriptName;

    /**
     * The selected URL.
     *
     * @var string
     */
    protected $selectedUrl;

    /**
     * Initializes a new instance.
     *
     * @param Themeswitcher_Model $model A model.
     *
     * @return void
     *
     * @global string The script name.
     * @global string The selected URL.
     */
    public function __construct(Themeswitcher_Model $model)
    {
        global $sn, $su;

        $this->model = $model;
        $this->scriptName = (string) $sn;
        $this->selectedUrl = (string) $su;
    }

    /**
     * Renders the view.
     *
     * @return string (X)HTML.
     */
    public function render()
    {
        return '<form class="themeswitcher_select_form" action="'
            . XH_hsc($this->scriptName) . '" method="get">'
            . $this->renderSelectedInput()
            . $this->renderSelect()
            . $this->renderSubmitButton()
            . '</form>';
    }

    /**
     * Renders the selected input element.
     *
     * @return string (X)HTML.
     */
    protected function renderSelectedInput()
    {
        return tag(
            'input type="hidden" name="selected" value="'
            . XH_hsc($this->selectedUrl) . '"'
        );
    }

    /**
     * Renders the select element.
     *
     * @return string (X)HTML.
     */
    protected function renderSelect()
    {
        $result = '<select name="themeswitcher_select">';
        foreach ($this->model->getThemes() as $theme) {
            $result .= $this->renderOption($theme);
        }
        $result .= '</select>';
        return $result;
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
        $theme = XH_hsc($theme);
        return tag('option label="' . $theme . '" value="' . $theme . '"');
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
}

?>

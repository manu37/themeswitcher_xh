<?php

/**
 * Testing the theme selection command.
 *
 * PHP version 5
 *
 * @category  Testing
 * @package   Themeswitcher
 * @author    Christoph M. Becker <cmbecker69@gmx.de>
 * @copyright 2014 Christoph M. Becker <http://3-magi.net>
 * @license   http://www.gnu.org/licenses/gpl-3.0.en.html GNU GPLv3
 * @version   SVN: $Id$
 * @link      http://3-magi.net/?CMSimple_XH/Themeswitcher_XH
 */

require_once '../../cmsimple/functions.php';
require_once './classes/Domain.php';
require_once './classes/Presentation.php';

/**
 * Testing the theme selection command.
 *
 * @category CMSimple_XH
 * @package  Themeswitcher
 * @author   Christoph M. Becker <cmbecker69@gmx.de>
 * @license  http://www.gnu.org/licenses/gpl-3.0.en.html GNU GPLv3
 * @link     http://3-magi.net/?CMSimple_XH/Themeswitcher_XH
 */
class ThemeSelectionCommandTest extends PHPUnit_Framework_TestCase
{
    private $_subject;

    /**
     * Sets up the test fixture.
     *
     * @return void
     *
     * @global string The script name.
     * @global string The selected URL.
     * @global array  The localization of the plugins.
     */
    public function setUp()
    {
        global $sn, $su, $plugin_tx;

        $sn = '/';
        $su = 'Welcome';
        $plugin_tx['themeswitcher'] = array(
            'label_activate' => 'Activate Theme'
        );
        $model = $this->getMock('Themeswitcher_Model');
        $model->expects($this->any())->method('getThemes')->will(
            $this->returnValue(array('one', 'three', 'two'))
        );
        $this->_subject = new Themeswitcher_ThemeSelectionCommand($model);
    }

    /**
     * Tests that the form is rendered.
     *
     * @return void
     *
     * @global string The script name.
     */
    public function testRendersForm()
    {
        global $sn;

        $matcher = array(
            'tag' => 'form',
            'attributes' => array(
                'class' => 'themeswitcher_select_form',
                'method' => 'get',
                'action' => $sn
            )
        );
        $this->_assertRenders($matcher);
    }

    /**
     * Test that the selected input element is rendered.
     *
     * @return void
     *
     * @global string The selected URL.
     */
    public function testRendersSelectedInput()
    {
        global $su;

        $matcher = array(
            'tag' => 'input',
            'attributes' => array(
                'type' => 'hidden',
                'name' => 'selected',
                'value' => $su
            ),
            'ancestor' => array('tag' => 'form')
        );
        $this->_assertRenders($matcher);
    }

    /**
     * Tests that the select element is rendered.
     *
     * @return void
     */
    public function testRendersSelect()
    {
        $matcher = array(
            'tag' => 'select',
            'attributes' => array(
                'name' => 'themeswitcher_select'
            ),
            'children' => array(
                'only' => array('tag' => 'option'),
                'count' => 3
            ),
            'ancestor' => array('tag' => 'form')
        );
        $this->_assertRenders($matcher);
    }

    /**
     * Tests that the "two" option is rendered.
     *
     * @return void
     */
    public function testRendersTwoOption()
    {
        $matcher = array(
            'tag' => 'option',
            'attributes' => array(
                'label' => 'two',
                'value' => 'two'
            ),
            'parent' => array('tag' => 'select')
        );
        $this->_assertRenders($matcher);
    }

    /**
     * Tests that the submit button is rendered.
     *
     * @return void
     *
     * @global array The localization of the plugins.
     */
    public function testRendersSubmitButton()
    {
        global $plugin_tx;

        $matcher = array(
            'tag' => 'button',
            'content' => $plugin_tx['themeswitcher']['label_activate'],
            'ancestor' => array('tag' => 'form')
        );
        $this->_assertRenders($matcher);
    }

    /**
     * Asserts that rendering matches a matcher.
     *
     * @param array $matcher A matcher.
     *
     * @return void
     */
    private function _assertRenders($matcher)
    {
        $this->assertTag($matcher, $this->_subject->render());
    }
}

?>

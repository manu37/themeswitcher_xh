<?php

/**
 * Testing the controller.
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

require_once './vendor/autoload.php';
require_once '../../cmsimple/adminfuncs.php';
require_once './classes/Presentation.php';

/**
 * Testing the controller.
 *
 * @category CMSimple_XH
 * @package  Themeswitcher
 * @author   Christoph M. Becker <cmbecker69@gmx.de>
 * @license  http://www.gnu.org/licenses/gpl-3.0.en.html GNU GPLv3
 * @link     http://3-magi.net/?CMSimple_XH/Themeswitcher_XH
 */
class ControllerTest extends PHPUnit_Framework_TestCase
{
    /**
     * The test subject.
     *
     * @var Themeswitcher_Controller
     */
    private $_subject;

    /**
     * The theme selection command.
     *
     * @var Themeswitcher_SelectionCommand
     */
    private $_themeSelectionCommand;

    /**
     * The info command.
     *
     * @var Themeswitcher_InfoCommand
     */
    private $_infoCommand;

    /**
     * The print_plugin_admin() mock.
     *
     * @var PHPUnit_Extensions_MockFunction
     */
    private $_printPluginAdmin;

    /**
     * Sets up the test fixture.
     *
     * @return void
     */
    public function setUp()
    {
        if (!defined('XH_ADM')) {
            define('XH_ADM', true);
        } else {
            runkit_constant_redefine('XH_ADM', true);
        }
        $commandFactory = $this->getMock('Themeswitcher_CommandFactory');
        $this->_themeSelectionCommand = $this
            ->getMockBuilder('Themeswitcher_ThemeSelectionCommand')
            ->disableOriginalConstructor()
            ->getMock();
        $commandFactory->expects($this->any())
            ->method('makeThemeSelectionCommand')
            ->will($this->returnValue($this->_themeSelectionCommand));
        $this->_selectThemeCommand = $this
            ->getMockBuilder('Themeswitcher_SelectThemeCommand')
            ->disableOriginalConstructor()
            ->getMock();
        $commandFactory->expects($this->any())
            ->method('makeSelectThemeCommand')
            ->will($this->returnValue($this->_selectThemeCommand));
        $this->_infoCommand = $this->getMockBuilder('Themeswitcher_InfoCommand')
            ->disableOriginalConstructor()->getMock();
        $commandFactory->expects($this->any())->method('makeInfoCommand')
            ->will($this->returnValue($this->_infoCommand));
        $this->_subject = new Themeswitcher_Controller($commandFactory);
        $this->_printPluginAdmin = new PHPUnit_Extensions_MockFunction(
            'print_plugin_admin', $this->_subject
        );
    }

    /**
     * Tests that a select theme command is executed on an appropriate GET request.
     *
     * @return void
     */
    public function testExecutesSelectThemeCommandOnGet()
    {
        $_GET = array('themeswitcher_select' => 'foo');
        $this->_selectThemeCommand->expects($this->once())->method('execute');
        $this->_subject->dispatch();
    }

    /**
     * Tests that a select theme command is executed on an appropriate COOKIE.
     *
     * @return void
     */
    public function testExecutesSelectThemeCommandOnCookie()
    {
        $_COOKIE = array('themeswitcher_theme' => 'foo');
        $this->_selectThemeCommand->expects($this->once())->method('execute');
        $this->_subject->dispatch();
    }

    /**
     * Tests that the info command is rendered.
     *
     * @return void
     *
     * @global string Whether the plugin is requested.
     * @global string The value of <var>admin</var> GP paramter.
     */
    public function testRendersInfoCommand()
    {
        global $themeswitcher, $admin;

        $themeswitcher = 'true';
        $admin = '';
        $this->_printPluginAdmin->expects($this->once());
        $this->_infoCommand->expects($this->once())->method('render');
        $this->_subject->dispatch();
    }

    /**
     * Tests that plugin_admin_common() is called.
     *
     * @return void
     *
     * @global string Whether the plugin is requested.
     * @global string The value of the <var>admin</var> GP paramter.
     * @global string The value of the <var>action</var> GP parameter.
     */
    public function testPluginAdminCommon()
    {
        global $themeswitcher, $admin, $action;

        $themeswitcher = 'true';
        $admin = 'plugin_config';
        $action = 'plugin_edit';
        $this->_printPluginAdmin->expects($this->once());
        $pluginAdminCommon = new PHPUnit_Extensions_MockFunction(
            'plugin_admin_common', $this->_subject
        );
        $pluginAdminCommon->expects($this->once())->with(
            $admin, $action, 'themeswitcher'
        );
        $this->_subject->dispatch();
    }

    /**
     * Tests the theme selection.
     *
     * @return void
     */
    public function testThemeSelection()
    {
        $this->_themeSelectionCommand->expects($this->once())->method('render');
        $this->_subject->renderThemeSelection();

    }
}

?>

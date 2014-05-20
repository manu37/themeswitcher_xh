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
     * Sets up the test fixture.
     *
     * @return void
     */
    public function setUp()
    {
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
        $this->_subject = new Themeswitcher_Controller($commandFactory);
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

<?php

/**
 * Testing the command factory.
 *
 * PHP version 5
 *
 * @category  Testing
 * @package   Themeswitcher
 * @author    Christoph M. Becker <cmbecker69@gmx.de>
 * @copyright 2014-2015 Christoph M. Becker <http://3-magi.net>
 * @license   http://www.gnu.org/licenses/gpl-3.0.en.html GNU GPLv3
 * @link      http://3-magi.net/?CMSimple_XH/Themeswitcher_XH
 */

require_once './classes/Domain.php';
require_once './classes/Presentation.php';

/**
 * Testing the command factory.
 *
 * @category CMSimple_XH
 * @package  Themeswitcher
 * @author   Christoph M. Becker <cmbecker69@gmx.de>
 * @license  http://www.gnu.org/licenses/gpl-3.0.en.html GNU GPLv3
 * @link     http://3-magi.net/?CMSimple_XH/Themeswitcher_XH
 */
class CommandFactoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * The test subject.
     *
     * @var Themeswitcher_CommandFactory
     */
    private $_subject;

    /**
     * Sets up the test fixtures.
     *
     * @return void
     */
    public function setUp()
    {
        $this->_subject = new Themeswitcher_CommandFactory();
    }

    /**
     * Tests making a theme selection command.
     *
     * @return void
     */
    public function testMakeThemeSelectionCommand()
    {
        $this->assertInstanceOf(
            'Themeswitcher_ThemeSelectionCommand',
            $this->_subject->makeThemeSelectionCommand()
        );
    }

    /**
     * Tests making a select theme command.
     *
     * @return void
     */
    public function testMakeSelectThemeCommand()
    {
        $this->assertInstanceOf(
            'Themeswitcher_SelectThemeCommand',
            $this->_subject->makeSelectThemeCommand()
        );
    }

    /**
     * Tests making an info command.
     *
     * @return void
     */
    public function testMakeInfoCommand()
    {
        $this->assertInstanceOf(
            'Themeswitcher_InfoCommand',
            $this->_subject->makeInfoCommand()
        );
    }
}

?>

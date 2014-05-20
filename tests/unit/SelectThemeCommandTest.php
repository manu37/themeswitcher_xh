<?php

/**
 * Testing the select theme command.
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
require_once '../../cmsimple/functions.php';
require_once './classes/Model.php';
require_once './classes/Presentation.php';

/**
 * Testing the select theme command.
 *
 * @category CMSimple_XH
 * @package  Themeswitcher
 * @author   Christoph M. Becker <cmbecker69@gmx.de>
 * @license  http://www.gnu.org/licenses/gpl-3.0.en.html GNU GPLv3
 * @link     http://3-magi.net/?CMSimple_XH/Themeswitcher_XH
 */
class SelectThemeCommandTest extends PHPUnit_Framework_TestCase
{
    /**
     * The test subject.
     *
     * @var Themeswitcher_SelectThemeCommand
     */
    private $_subject;

    /**
     * The model.
     *
     * @var Themeswitcher_Model
     */
    private $_model;

    /**
     * The setcookie mock.
     *
     * @var PHPUnit_Extensions_MockFunction
     */
    private $_setcookie;

    /**
     * Sets up the test fixture.
     *
     * @return void
     */
    public function setUp()
    {
        if (!defined('CMSIMPLE_ROOT')) {
            define('CMSIMPLE_ROOT', '/');
        }
        $this->_model = $this->getMock('Themeswitcher_Model');
        $this->_subject = new Themeswitcher_SelectThemeCommand($this->_model);
        $this->_setcookie = new PHPUnit_Extensions_MockFunction(
            'setcookie', $this->_subject
        );
    }

    /**
     * Tests that the template is switched on the appropriate GET request.
     *
     * @return void
     */
    public function testSwitchesTemplateOnGet()
    {
        $_GET = array('themeswitcher_select' => 'foo');
        $this->_model->expects($this->once())->method('switchTemplate')
            ->with($this->equalTo('foo'));
        $this->_subject->execute();
    }

    /**
     * Tests that the template is switched on the appropriate cookie.
     *
     * @return void
     */
    public function testSwitchesTemplateOnCookie()
    {
        $_COOKIE = array('themeswitcher_theme' => 'foo');
        $this->_model->expects($this->once())->method('switchTemplate')
            ->with($this->equalTo('foo'));
        $this->_subject->execute();
    }

    /**
     * Tests that the cookie is set on the appropriate GET request.
     *
     * @return void
     */
    public function testCookieIsSetOnGet()
    {
        $_GET = array('themeswitcher_select' => 'foo');
        $this->_setcookie->expects($this->once())->with(
            'themeswitcher_theme', 'foo', 0, CMSIMPLE_ROOT
        );
        $this->_subject->execute();
    }

    /**
     * Tests that no cookie is set on the appropriate cookie.
     *
     * @return void
     */
    public function testNoCookieIsSetOnCookie()
    {
        $_COOKIE = array('themeswitcher_theme' => 'foo');
        $this->_setcookie->expects($this->never());
        $this->_subject->execute();
    }
}

?>

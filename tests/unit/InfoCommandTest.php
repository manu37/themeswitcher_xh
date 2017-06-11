<?php

/**
 * Testing the info command.
 *
 * PHP version 5
 *
 * @category  Testing
 * @package   Themeswitcher
 * @author    Christoph M. Becker <cmbecker69@gmx.de>
 * @copyright 2014-2017 Christoph M. Becker <http://3-magi.net>
 * @license   http://www.gnu.org/licenses/gpl-3.0.en.html GNU GPLv3
 * @link      http://3-magi.net/?CMSimple_XH/Themeswitcher_XH
 */

require_once './classes/InfoCommand.php';

/**
 * Testing the info command.
 *
 * @category CMSimple_XH
 * @package  Themeswitcher
 * @author   Christoph M. Becker <cmbecker69@gmx.de>
 * @license  http://www.gnu.org/licenses/gpl-3.0.en.html GNU GPLv3
 * @link     http://3-magi.net/?CMSimple_XH/Themeswitcher_XH
 */
class InfoCommandTest extends PHPUnit_Framework_TestCase
{
    /**
     * The test subject.
     *
     * @var Themeswitcher_InfoCommand
     */
    protected $subject;

    /**
     * Sets up the test fixture.
     *
     * @return void
     */
    public function setUp()
    {
        if (!defined('THEMESWITCHER_VERSION')) {
            define('THEMESWITCHER_VERSION', '1.0');
        } else {
            runkit_constant_redefine('THEMESWITCHER_VERSION', '1.0');
        }
        $this->subject = new Themeswitcher_InfoCommand();
    }

    /**
     * Tests that a heading is rendered.
     *
     * @return void
     */
    public function testRendersHeading()
    {
        $matcher = array(
            'tag' => 'h1',
            'content' => "Themeswitcher \xE2\x80\x93 Info"
        );
        $this->assertRenders($matcher);
    }

    /**
     * Tests that the version info is rendered.
     *
     * @return void
     */
    public function testRendersVersion()
    {
        $matcher = array(
            'tag' => 'p',
            'content' => 'Version: ' . THEMESWITCHER_VERSION
        );
        $this->assertRenders($matcher);
    }

    /**
     * Tests that the copyright is rendered.
     *
     * @return void
     */
    public function testRendersCopyright()
    {
        $matcher = array(
            'tag' => 'p',
            'content' => "Copyright \xC2\xA9"
        );
        $this->assertRenders($matcher);
    }

    /**
     * Renders the license.
     *
     * @return string (X)HTML.
     */
    public function testRendersLicense()
    {
        $matcher = array(
            'tag' => 'p',
            'attributes' => array('class' => 'themeswitcher_license'),
            'content' => 'Themeswitcher_XH is free software:'
        );
        $this->assertRenders($matcher);
    }

    /**
     * Asserts that rendering matches a matcher.
     *
     * @param array $matcher A matcher.
     *
     * @return void
     */
    protected function assertRenders($matcher)
    {
        @$this->assertTag($matcher, $this->subject->render());
    }
}

?>

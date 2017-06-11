<?php

/**
 * Testing the themeswitcher model.
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

require_once './vendor/autoload.php';

require_once '../../cmsimple/functions.php';
require_once './classes/Model.php';

use org\bovigo\vfs\vfsStreamWrapper;
use org\bovigo\vfs\vfsStreamDirectory;
use org\bovigo\vfs\vfsStream;

/**
 * Testing the themeswitcher model.
 *
 * @category CMSimple_XH
 * @package  Themeswitcher
 * @author   Christoph M. Becker <cmbecker69@gmx.de>
 * @license  http://www.gnu.org/licenses/gpl-3.0.en.html GNU GPLv3
 * @link     http://3-magi.net/?CMSimple_XH/Themeswitcher_XH
 */
class ModelTest extends PHPUnit_Framework_TestCase
{
    /**
     * The test subject.
     *
     * @var Themeswitcher_Model
     */
    protected $subject;

    /**
     * The paths of the theme folder.
     *
     * @var string
     */
    protected $themeFolder;

    /**
     * Sets up the test fixture.
     *
     * @return void
     *
     * @global array The paths of system files and folders.
     */
    public function setUp()
    {
        global $pth;

        vfsStreamWrapper::register();
        vfsStreamWrapper::setRoot(new vfsStreamDirectory('templates'));
        $this->themeFolder = vfsStream::url('templates/');
        foreach (array('one', 'two', 'three') as $theme) {
            mkdir($this->themeFolder . $theme, 0777, true);
            touch($this->themeFolder . $theme . '/template.htm');
        }
        $pth = array('folder' => array('templates' => $this->themeFolder));
        $this->subject = new Themeswitcher_Model();
    }

    /**
     * Tests that expected themes are returned.
     *
     * @return void
     */
    public function testGetThemes()
    {
        $this->assertEquals(
            array('one', 'three', 'two'),
            $this->subject->getThemes()
        );
    }

    /**
     * Tests that switch theme switches the theme.
     *
     * @return void
     *
     * @global array The paths of system files and folders.
     */
    public function testSwitchTheme()
    {
        global $pth;

        $this->subject->switchTheme('two');
        $this->assertEquals(
            array(
                'folder' => array(
                    'templates' => $this->themeFolder,
                    'template' => $this->themeFolder . 'two/',
                    'menubuttons' => $this->themeFolder . 'two/menu/',
                    'templateimages' => $this->themeFolder . 'two/images/'
                ),
                'file' => array(
                    'template' => $this->themeFolder . 'two/template.htm',
                    'stylesheet' => $this->themeFolder . 'two/stylesheet.css'
                )
            ),
            $pth
        );
    }
}


?>

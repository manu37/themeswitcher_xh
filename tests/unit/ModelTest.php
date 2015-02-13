<?php

/**
 * Testing the themeswitcher model.
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

require_once './vendor/autoload.php';

require_once '../../cmsimple/functions.php';
require_once './classes/Domain.php';

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
    private $_subject;

    private $_themeFolder;

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
        $this->_themeFolder = vfsStream::url('templates/');
        foreach (array('one', 'two', 'three') as $theme) {
            mkdir($this->_themeFolder . $theme, 0777, true);
            touch($this->_themeFolder . $theme . '/template.htm');
        }
        $pth = array('folder' => array('templates' => $this->_themeFolder));
        $this->_subject = new Themeswitcher_Model();
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
            $this->_subject->getThemes()
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

        $this->_subject->switchTheme('two');
        $this->assertEquals(
            array(
                'folder' => array(
                    'templates' => $this->_themeFolder,
                    'template' => $this->_themeFolder . 'two/',
                    'menubuttons' => $this->_themeFolder . 'two/menu/',
                    'templateimages' => $this->_themeFolder . 'two/images/'
                ),
                'file' => array(
                    'template' => $this->_themeFolder . 'two/template.htm',
                    'stylesheet' => $this->_themeFolder . 'two/stylesheet.css'
                )
            ),
            $pth
        );
    }
}


?>

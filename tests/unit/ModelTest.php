<?php

/**
 * Testing the themeswitcher model.
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

    private $_templateFolder;

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
        $this->_templateFolder = vfsStream::url('templates/');
        foreach (array('one', 'two', 'three') as $template) {
            mkdir($this->_templateFolder . $template, 0777, true);
            touch($this->_templateFolder . $template . '/template.htm');
        }
        $pth = array('folder' => array('templates' => $this->_templateFolder));
        $this->_subject = new Themeswitcher_Model();
    }

    /**
     * Tests that expected templates are returned.
     *
     * @return void
     */
    public function testTemplates()
    {
        $this->assertEquals(
            array('one', 'three', 'two'),
            $this->_subject->getTemplates()
        );
    }

    /**
     * Tests that switch template switches the template.
     *
     * @return void
     *
     * @global array The paths of system files and folders.
     */
    public function testSwitchTemplate()
    {
        global $pth;

        $this->_subject->switchTemplate('two');
        $this->assertEquals(
            array(
                'folder' => array(
                    'templates' => $this->_templateFolder,
                    'template' => $this->_templateFolder . 'two/',
                    'menubuttons' => $this->_templateFolder . 'two/menu/',
                    'templateimages' => $this->_templateFolder . 'two/images/'
                ),
                'file' => array(
                    'template' => $this->_templateFolder . 'two/template.htm',
                    'stylesheet' => $this->_templateFolder . 'two/stylesheet.css'
                )
            ),
            $pth
        );
    }
}


?>

<?php

/**
 * Copyright (C) 2014-2017 Christoph M. Becker
 *
 * This file is part of Themeswitcher_XH.
 *
 * Themeswitcher_XH is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Themeswitcher_XH is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Themeswitcher_XH.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Themeswitcher;

use PHPUnit_Framework_TestCase;
use PHPUnit_Extensions_MockFunction;

class ControllerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Controller
     */
    private $subject;

    /**
     * @var SelectionCommand
     */
    private $themeSelectionCommand;

    /**
     * @var InfoCommand
     */
    private $infoCommand;

    /**
     * @var PHPUnit_Extensions_MockFunction
     */
    private $printPluginAdmin;

    /**
     * @return void
     */
    public function setUp()
    {
        if (!defined('XH_ADM')) {
            define('XH_ADM', true);
        } else {
            runkit_constant_redefine('XH_ADM', true);
        }
        $commandFactory = $this->getMock('Themeswitcher\CommandFactory');
        $this->themeSelectionCommand = $this
            ->getMockBuilder('Themeswitcher\ThemeSelectionCommand')
            ->disableOriginalConstructor()
            ->getMock();
        $commandFactory->expects($this->any())
            ->method('makeThemeSelectionCommand')
            ->will($this->returnValue($this->themeSelectionCommand));
        $this->_selectThemeCommand = $this
            ->getMockBuilder('Themeswitcher\SelectThemeCommand')
            ->disableOriginalConstructor()
            ->getMock();
        $commandFactory->expects($this->any())
            ->method('makeSelectThemeCommand')
            ->will($this->returnValue($this->_selectThemeCommand));
        $this->infoCommand = $this->getMockBuilder('Themeswitcher\InfoCommand')
            ->disableOriginalConstructor()->getMock();
        $commandFactory->expects($this->any())->method('makeInfoCommand')
            ->will($this->returnValue($this->infoCommand));
        $this->subject = new Controller($commandFactory);
        $this->printPluginAdmin = new PHPUnit_Extensions_MockFunction('print_plugin_admin', $this->subject);
        new PHPUnit_Extensions_MockFunction('XH_registerStandardPluginMenuItems', $this->subject);
    }

    /**
     * @return void
     */
    public function testExecutesSelectThemeCommandOnGet()
    {
        $_POST = array('themeswitcher_select' => 'foo');
        $this->_selectThemeCommand->expects($this->once())->method('execute');
        $this->subject->dispatch();
    }

    /**
     * @return void
     */
    public function testExecutesSelectThemeCommandOnCookie()
    {
        $_COOKIE = array('themeswitcher_theme' => 'foo');
        $this->_selectThemeCommand->expects($this->once())->method('execute');
        $this->subject->dispatch();
    }

    /**
     * @return void
     */
    public function testRendersInfoCommand()
    {
        global $themeswitcher, $admin;

        $themeswitcher = 'true';
        $admin = '';
        $this->printPluginAdmin->expects($this->once());
        $this->infoCommand->expects($this->once())->method('render');
        $this->subject->dispatch();
    }

    /**
     * @return void
     */
    public function testPluginAdminCommon()
    {
        global $themeswitcher, $admin, $action;

        $themeswitcher = 'true';
        $admin = 'plugin_config';
        $action = 'plugin_edit';
        $this->printPluginAdmin->expects($this->once());
        $pluginAdminCommon = new PHPUnit_Extensions_MockFunction('plugin_admin_common', $this->subject);
        $pluginAdminCommon->expects($this->once())->with($action, $admin, 'themeswitcher');
        $this->subject->dispatch();
    }

    /**
     * @return void
     */
    public function testThemeSelection()
    {
        $this->themeSelectionCommand->expects($this->once())->method('render');
        $this->subject->renderThemeSelection();
    }
}

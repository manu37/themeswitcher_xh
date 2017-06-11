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

class SelectThemeCommandTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var SelectThemeCommand
     */
    private $subject;

    /**
     * @var Model
     */
    private $model;

    /**
     * @var PHPUnit_Extensions_MockFunction
     */
    private $setcookie;

    /**
     * @return void
     */
    public function setUp()
    {
        if (!defined('CMSIMPLE_ROOT')) {
            define('CMSIMPLE_ROOT', '/');
        }
        $this->model = $this->createMock('Themeswitcher\Model');
        $this->model->expects($this->any())->method('getThemes')
            ->will($this->returnValue(array('one', 'three', 'two')));
        $this->subject = new SelectThemeCommand($this->model);
        $this->setcookie = new PHPUnit_Extensions_MockFunction('setcookie', $this->subject);
    }

    /**
     * @return void
     */
    public function testSwitchesThemeOnGet()
    {
        $_POST = array('themeswitcher_select' => 'one');
        $this->model->expects($this->once())->method('switchTheme')
            ->with($this->equalTo('one'));
        $this->subject->execute();
    }

    /**
     * @return void
     */
    public function testSwitchesThemeOnCookie()
    {
        $_COOKIE = array('themeswitcher_theme' => 'one');
        $this->model->expects($this->once())->method('switchTheme')
            ->with($this->equalTo('one'));
        $this->subject->execute();
    }

    /**
     * @return void
     */
    public function testDontSwitchThemeIfNotAllowed()
    {
        $_POST = array('themeswitcher_select' => 'foo');
        $this->model->expects($this->never())->method('switchTheme');
        $this->subject->execute();
    }

    /**
     * @return void
     */
    public function testSwitchThemeIfPageThemeIsNotPreferred()
    {
        global $pd_current, $plugin_cf;

        $pd_current = array('template' => 'two');
        $plugin_cf = array('themeswitcher' => array('prefer_page_theme' => ''));
        $_POST = array('themeswitcher_select' => 'one');
        $this->model->expects($this->once())->method('switchTheme');
        $this->subject->execute();
    }

    /**
     * @return void
     */
    public function testDontSwitchThemeIfPageTemplateIsPreferred()
    {
        global $pd_current, $plugin_cf;

        $pd_current = array('template' => 'two');
        $plugin_cf = array('themeswitcher' => array('prefer_page_theme' => 'true'));
        $_POST = array('themeswitcher_select' => 'one');
        $this->model->expects($this->never())->method('switchTheme');
        $this->subject->execute();
    }

    /**
     * @return void
     */
    public function testCookieIsSetOnGet()
    {
        $_POST = array('themeswitcher_select' => 'one');
        $this->setcookie->expects($this->once())->with('themeswitcher_theme', 'one', 0, CMSIMPLE_ROOT);
        $this->subject->execute();
    }

    /**
     * @return void
     */
    public function testNoCookieIsSetOnCookie()
    {
        $_COOKIE = array('themeswitcher_theme' => 'one');
        $this->setcookie->expects($this->never());
        $this->subject->execute();
    }
}

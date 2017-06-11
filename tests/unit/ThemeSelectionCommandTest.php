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

class ThemeSelectionCommandTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var ThemeSelectionCommand
     */
    private $subject;

    /**
     * @return void
     */
    public function setUp()
    {
        global $sn, $su, $plugin_tx;

        $sn = '/';
        $su = 'Welcome';
        $plugin_tx['themeswitcher'] = array(
            'label_activate' => 'Activate Theme'
        );
        $model = $this->getMock('Themeswitcher\Model');
        $model->expects($this->any())->method('getThemes')->will(
            $this->returnValue(array('one', 'three', 'two'))
        );
        $this->subject = new ThemeSelectionCommand($model);
    }

    /**
     * @return void
     */
    public function testRendersForm()
    {
        global $sn;

        $matcher = array(
            'tag' => 'form',
            'attributes' => array(
                'class' => 'themeswitcher_select_form',
                'method' => 'post'
            )
        );
        $this->assertRenders($matcher);
    }

    /**
     * @return void
     */
    public function testRendersSelect()
    {
        $matcher = array(
            'tag' => 'select',
            'attributes' => array(
                'name' => 'themeswitcher_select'
            ),
            'children' => array(
                'only' => array('tag' => 'option'),
                'count' => 3
            ),
            'ancestor' => array('tag' => 'form')
        );
        $this->assertRenders($matcher);
    }

    /**
     * @return void
     */
    public function testRendersTwoOption()
    {
        $matcher = array(
            'tag' => 'option',
            'attributes' => array(
                'value' => 'two'
            ),
            'content' => 'two',
            'parent' => array('tag' => 'select')
        );
        $this->assertRenders($matcher);
    }

    /**
     * @return void
     */
    public function testRendersSubmitButton()
    {
        global $plugin_tx;

        $matcher = array(
            'tag' => 'button',
            'content' => $plugin_tx['themeswitcher']['label_activate'],
            'ancestor' => array('tag' => 'form')
        );
        $this->assertRenders($matcher);
    }

    /**
     * @return void
     */
    private function assertRenders(array $matcher)
    {
        @$this->assertTag($matcher, $this->subject->render());
    }
}

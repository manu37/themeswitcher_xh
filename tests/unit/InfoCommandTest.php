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

class InfoCommandTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var InfoCommand
     */
    private $subject;

    /**
     * @return void
     */
    public function setUp()
    {
        if (!defined('THEMESWITCHER_VERSION')) {
            define('THEMESWITCHER_VERSION', '1.0');
        } else {
            runkit_constant_redefine('THEMESWITCHER_VERSION', '1.0');
        }
        $this->subject = new InfoCommand();
    }

    /**
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
     * @return void
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
     * @return void
     */
    private function assertRenders(array $matcher)
    {
        @$this->assertTag($matcher, $this->subject->render());
    }
}

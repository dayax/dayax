<?php

/*
 * This file is part of the dayax package.
 *
 * (c) Toni Munthi <me@itstoni.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace dayax\test\tests;

use dayax\test\WebTestCase;

class WebTestCaseTest extends WebTestCase
{
    public function testOpen()
    {
        $this->open('html/test_open.html');
        $this->assertStringEndsWith('html/test_open.html', $this->getLocation());
        $this->assertEquals('This is a test of the open command',$this->getBodyText());
    }
}

?>
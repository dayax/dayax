<?php

/*
 * This file is part of the dayax package.
 *
 * (c) Toni Munthi <me@itstoni.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace dayax\test;

class WebTestCase extends \PHPUnit_Framework_TestCase
{
    private $crawler;
    private $client;

    protected function open($url)
    {
        $this->markTestIncomplete();
    }

    public function getLocation()
    {
        $this->markTestIncomplete();
    }

    public function assertTitle()
    {
        $this->markTestIncomplete();
    }


}
?>

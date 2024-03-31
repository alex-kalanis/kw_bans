<?php

use kalanis\kw_bans\Who;
use kalanis\kw_bans\Ip;


class BasicEntriesTest extends CommonTestClass
{
    public function testIpEntry(): void
    {
        $data = new Ip();
        $data->setData(7,  ['abc','def','ghi'], 33);
        $this->assertEquals(7, $data->getType());
        $this->assertEquals(['abc', 'def', 'ghi'], $data->getAddress());
        $this->assertEquals(33, $data->getAffectedBits());
    }

    public function testWhoEntry(): void
    {
        $data = new Who();
        $data->setData('abcdefghijkl',  'mnopqrstuvwx', 'yz0123456789');
        $this->assertEquals('abcdefghijkl', $data->getName());
        $this->assertEquals('mnopqrstuvwx', $data->getBrowser());
        $this->assertEquals('yz0123456789', $data->getIpAddress());
    }
}

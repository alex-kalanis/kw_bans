<?php

use kalanis\kw_bans\Sources;
use kalanis\kw_bans\BanException;


class SourcesTest extends CommonTestClass
{
    public function testArrays(): void
    {
        $data = new Sources\Arrays(['abcdefghijkl',  'mnopqrstuvwx', 'yz0123456789']);
        $records = $data->getRecords();
        $this->assertEquals('abcdefghijkl', reset($records));
        $this->assertEquals('mnopqrstuvwx', next($records));
        $this->assertEquals('yz0123456789', next($records));
    }

    /**
     * @throws BanException
     */
    public function testFiles(): void
    {
        $data = new Sources\File(realpath(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'testfile.txt'));
        $records = $data->getRecords();
        $this->assertEquals(3, count($records));
        $this->assertEquals('abcdefghijkl', reset($records));
        $this->assertEquals('mnopqrstuvwx', next($records));
        $this->assertEquals('yz0123456789', next($records));
    }

    /**
     * @throws BanException
     */
    public function testNoFile(): void
    {
        $this->expectException(BanException::class);
        new Sources\File(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'not_exists');
    }
}

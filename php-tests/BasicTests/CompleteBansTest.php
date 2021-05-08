<?php

use kalanis\kw_bans\Bans;


class CompleteBansTest extends CommonTestClass
{
    /**
     * @param array $compareData
     * @param bool $isBanned
     * @dataProvider completeBansProvider
     */
    public function testEntry(array $compareData, bool $isBanned)
    {
        $data = new Bans(['qwer', 'tzui', 'asdf', 'ghjk'], ['qwer*', 'tzui', 'asdf', 'ghjk?'], ['10.0.0.1', '127..1', '10../8']);
        $this->assertEquals($isBanned, $data->has(...$compareData));
    }

    public function completeBansProvider()
    {
        return [
            [['poiu', 'lkjh', '127.0.0.8'], false],
            [['ertzuio', 'lkjh', '10..250'], true],
            [['poiu', 'tz:ui', '10..250'], true],
        ];
    }
}

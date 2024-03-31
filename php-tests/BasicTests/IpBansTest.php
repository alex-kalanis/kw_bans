<?php

use kalanis\kw_bans\Bans;
use kalanis\kw_bans\Sources;
use kalanis\kw_bans\BanException;


class IpBansTest extends CommonTestClass
{
    /**
     * @param array $inWhat
     * @param string $looked
     * @param bool $isBanned
     * @throws BanException
     * @dataProvider ip4Provider
     */
    public function testIp4Entry(array $inWhat, string $looked, bool $isBanned): void
    {
        $data = new Bans\IP4(new Sources\Arrays($inWhat));
        $data->setLookedFor($looked);
        $this->assertEquals($isBanned, $data->isBanned());
    }

    /**
     * @param array $inWhat
     * @param string $looked
     * @param bool $isBanned
     * @throws BanException
     * @dataProvider ip6Provider
     */
    public function testIp6Entry(array $inWhat, string $looked, bool $isBanned): void
    {
        $data = new Bans\IP6(new Sources\Arrays($inWhat));
        $data->setLookedFor($looked);
        $this->assertEquals($isBanned, $data->isBanned());
    }

    public function ip4Provider(): array
    {
        return [
            [['10..', ], '40..', false],
            [['10../10', ], '40..', false],
            [['10../8', ], '10..2', true],
            [['10../8', ], '10..224', true],
            [['10../6', ], '10..2', true],
            [['10../6', ], '10..224', false],
            [['10..', '127..1', '10.1.0.10', '10.1.1.1', '10.10.10.10', '10.20.30.40'], '40..', false],
            [['10.1.*.10', '10.1.1?.1'], '10.1.70.10', true],
            [['10.1.*.10', '10.1.1?.1'], '10.1.70.80', false],
            [['10.1.*.10', '10.1.1?.1'], '10.1.11.10', true],
            [['10.1.*.10', '10.1.1?.1'], '10.1.11.80', false],
        ];
    }

    public function ip6Provider(): array
    {
        return [
            [['::1', ], '::7', false],
            [['::128/10', ], '::afff', false],
            [['::f0f0/8', ], '::f0f0', true],
        ];
    }
}

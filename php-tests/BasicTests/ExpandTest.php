<?php

use kalanis\kw_bans\BanException;
use kalanis\kw_bans\Ip;
use kalanis\kw_bans\Traits;
use kalanis\kw_bans\Translations;


class ExpandTest extends CommonTestClass
{
    /**
     * @param string $inIp
     * @param array $onParts
     * @param int $mask
     * @param bool $canCrash
     * @throws BanException
     * @dataProvider basicExpandProvider
     */
    public function testBasicExpand(string $inIp, array $onParts, int $mask, bool $canCrash): void
    {
        $data = new XExpandIp();
        if ($canCrash) $this->expectException(BanException::class);
        $ip = $data->expandIP($inIp);
        if (!$canCrash) {
            $this->assertEquals($onParts, $ip->getAddress());
            $this->assertEquals($mask, $ip->getAffectedBits());
        }
    }

    public function basicExpandProvider(): array
    {
        return [
            ['asdf.ghjk.qwer.tzui', ['asdf', 'ghjk', 'qwer', 'tzui'], 0, false], // not need to expand
            ['asdf.ghjk.qwer.tzui/23', ['asdf', 'ghjk', 'qwer', 'tzui'], 23, false], // affected bits
            ['asdf..tzui', ['asdf', '0', '0', 'tzui'], 0, false], // simple expand
            ['asdf..', ['asdf', '0', '0', '0'], 0, false], // simple expand to the end
            ['..tzui', ['0', '0', '0', 'tzui'], 0, false], // simple expand from start
            ['asdf.ghjk.qwer..tzui', ['asdf', 'ghjk', 'qwer', 'tzui'], 0, false], // no need to expand
            ['asdf.ghjk.qwer.tzui.op', [], 0, true], // bad amount of blocks
            ['asdf.ghjk.qwer.tzui..op', [], 0, true], // bad amount of blocks after expand
        ];
    }

    /**
     * @throws BanException
     */
    public function testBasicExpandFailedEmptyDelimiter(): void
    {
        $data = new XFailExpandIp();
        $this->expectException(BanException::class);
        $data->expandIP('asdf.ghjk.qwer.tzui');
    }
}


class XExpandIp
{
    use Traits\TExpandIp;
    use Traits\TLang;
    use Traits\TIp;

    public function __construct()
    {
        $this->setBasicIp(null);
    }
}


class XFailExpandIp
{
    use Traits\TExpandIp;
    use Traits\TLang;
    use Traits\TIp;

    public function __construct()
    {
        $this->delimiter = ''; // intentionally empty!
        $this->setIKbLang(new Translations());
        $this->setBasicIp(new Ip());
    }
}

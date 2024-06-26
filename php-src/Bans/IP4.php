<?php

namespace kalanis\kw_bans\Bans;


use kalanis\kw_bans\Interfaces\IIpTypes;


class IP4 extends AIP
{
    protected int $type = IIpTypes::TYPE_IP_4;
    protected int $blocks = 4;
    protected string $delimiter = '.';
    protected int $bitsInBlock = 8;

    protected function toNumber(string $value): int
    {
        return intval($value);
    }
}

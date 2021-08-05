<?php

namespace kalanis\kw_bans\Bans;


use kalanis\kw_bans\Interfaces\IIpTypes;


/**
 * Class IP6
 * @package kalanis\kw_bans\Bans
 * Check IP address v6
 */
class IP6 extends AIP
{
    protected $type = IIpTypes::TYPE_IP_6;
    protected $blocks = 8;
    protected $delimiter = ':';
    protected $bitsInBlock = 16;

    protected function toNumber(string $value): int
    {
        return hexdec($value);
    }
}

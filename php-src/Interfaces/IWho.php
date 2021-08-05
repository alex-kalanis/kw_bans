<?php

namespace kalanis\kw_bans\Interfaces;


/**
 * Interface IWho
 * @package kalanis\kw_bans\Interfaces
 * Who will be checked for bans?
 */
interface IWho
{
    public function getIpAddress(): string;

    public function getBrowser(): string;

    public function getName(): string;
}

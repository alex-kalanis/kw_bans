<?php

namespace kalanis\kw_bans\Bans;


/**
 * Class Clearing
 * @package kalanis\kw_bans\Bans
 * Strings cleared of specific characters - for checking names
 */
class Clearing extends Basic
{
    public function setLookedFor(string $lookedFor): void
    {
        parent::setLookedFor(strtr($lookedFor, ["*" => "", "?" => "", ":" => "", ";" => "", "\\" => "", "/" => ""]));
    }
}

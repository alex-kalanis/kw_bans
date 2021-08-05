<?php

namespace kalanis\kw_bans\Sources;


use kalanis\kw_bans\BanException;


/**
 * Class File
 * @package kalanis\kw_bans\Sources
 * Bans source is file somewhere
 */
class File extends ASources
{
    public function __construct(string $file)
    {
        $rows = @file($file);
        if (false === $rows) {
            throw new BanException('Defined file was not found');
        }

        // remove empty records
        $rows = array_filter($rows);

        // sort them, better for lookup
        sort($rows);

        // last clearing
        $this->knownRecords = array_map(function ($row) {
            return strtr($row, ["\r" => "", "\n" => ""]);
        }, $rows);

    }
}

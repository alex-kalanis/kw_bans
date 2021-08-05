<?php

namespace kalanis\kw_bans\Bans;


use kalanis\kw_bans\Sources\ASources;


/**
 * Class ABan
 * @package kalanis\kw_bans\Bans
 * Abstraction of single banning lookup
 * You also can get which records matches the lookup phrase
 */
abstract class ABan
{
    /** @var string[] */
    protected $foundRecords = [];

    /**
     * ABan constructor.
     * Set source which will be processed for banned records
     * @param ASources $source
     */
    abstract public function __construct(ASources $source);

    /**
     * Set the phrase which will be looked for in banned records
     * @param string $lookedFor
     */
    abstract public function setLookedFor(string $lookedFor): void;

    /**
     * Processing check
     * @return bool
     */
    public function isBanned(): bool
    {
        $this->compare();
        return !empty($this->foundRecords);
    }

    /**
     * Check itself
     * Fill records which has been found
     */
    abstract protected function compare(): void;
}

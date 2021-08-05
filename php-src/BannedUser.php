<?php

namespace kalanis\kw_bans;


use kalanis\kw_bans\Interfaces\IWho;


/**
 * Class BannedUser
 * @package kalanis\kw_bans
 * @codeCoverageIgnore for now...
 */
class BannedUser
{
    /** @var Bans\ABan */
    protected $sourceIp = null;
    /** @var Bans\ABan */
    protected $sourceBrowser = null;
    /** @var Bans\ABan */
    protected $sourceName = null;

    public function __construct($sourceIp, $sourceBrowser, $sourceName)
    {
        $factory = new Bans\Factory();
        $this->sourceIp = $factory->whichType($sourceIp);
        $this->sourceBrowser = $factory->whichType($sourceBrowser);
        $this->sourceName = $factory->whichType($sourceName);
    }

    public function has(IWho $user): bool
    {
        $this->sourceIp->setLookedFor($user->getIpAddress());
        $this->sourceName->setLookedFor($user->getName());
        $this->sourceBrowser->setLookedFor($user->getBrowser());
        return (
            $this->sourceIp->isBanned()
            || $this->sourceName->isBanned()
            || $this->sourceBrowser->isBanned()
        );
    }
}

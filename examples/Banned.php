<?php

namespace kalanis\kw_bans\examples;


use kalanis\kw_bans\BanException;
use kalanis\kw_bans\Bans;
use kalanis\kw_bans\Sources\File;


/**
 * Class Banned
 * @package kalanis\kw_bans\examples
 * Throws an exception if incoming user is banned
 * Just add it before any other method which try to log user in
 * Got from kw_auth class where it's one of methods
 *
 * Files are simple - each one contains list of records, each record on new line
 */
class Banned
{
    public const BAN_IP4 = 'ban_ip4.txt';
    public const BAN_IP6 = 'ban_ip6.txt';
    public const BAN_NAME = 'ban_name.txt';

    protected const PREG_IP4 = '#^[0-9\./]$#i';
    protected const PREG_IP6 = '#^[0-9a-f:/]$#i';
    protected const PREG_NAME = '#^[\*\?\:;\\//]$#i';

    protected Bans $libBan;

    /**
     * @throws BanException
     */
    public function __construct()
    {
        $banPath = $this->getBanPath();
        $this->libBan = new Bans(
            null,
            new File($banPath . DIRECTORY_SEPARATOR . self::BAN_IP4),
            new File($banPath . DIRECTORY_SEPARATOR . self::BAN_IP6),
            new File($banPath . DIRECTORY_SEPARATOR . self::BAN_NAME)
        );
    }

    protected function getBanPath(): string
    {
        return __DIR__ . DIRECTORY_SEPARATOR . 'conf';
    }

    /**
     * @param \ArrayAccess $credentials
     * @throws BanException
     */
    public function process(\ArrayAccess $credentials): void
    {
        $name = $credentials->offsetExists('user') ? $credentials->offsetGet('user') : '' ;
        $ip = $_SERVER["REMOTE_ADDR"];
        if ($this->libBan->has(
            preg_replace(static::PREG_IP4, '', $ip),
            preg_replace(static::PREG_IP6, '', $ip),
            preg_replace(static::PREG_NAME, '', $name)
        )) {
            throw new BanException('Accessing user is banned!', 401);
        }
    }
}

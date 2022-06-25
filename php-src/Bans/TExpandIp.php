<?php

namespace kalanis\kw_bans\Bans;


use kalanis\kw_bans\BanException;
use kalanis\kw_bans\Interfaces\IIpTypes;
use kalanis\kw_bans\Interfaces\IKBTranslations;
use kalanis\kw_bans\Ip;


trait TExpandIp
{
    /** @var int */
    protected $type = IIpTypes::TYPE_NONE;
    /** @var int */
    protected $blocks = 4;
    /** @var string */
    protected $delimiter = '.';

    /**
     * @param string $knownIp
     * @throws BanException
     * @return Ip
     */
    public function expandIP(string $knownIp): Ip
    {
        $affectedBits = 0; // aka ignore last bits...
        $subnetMaskPosition = strpos($knownIp, IIpTypes::MASK_SEPARATOR);
        if (false !== $subnetMaskPosition) {
            $affectedBits = intval(substr($knownIp, $subnetMaskPosition + 1));
            $knownIp = substr($knownIp, 0, $subnetMaskPosition);
        }

        if (empty($this->delimiter)) {
            throw new BanException($this->getLang()->ikbBadIpParsingNoDelimiter());
        }

        $shortenedPart = strpos($knownIp, $this->delimiter . $this->delimiter);
        if (false !== $shortenedPart) {
            $beginPart = (0 == $shortenedPart) ? [] : (array) explode($this->delimiter, substr($knownIp, 0, $shortenedPart));
            $cutEnd = $shortenedPart + strlen($this->delimiter . $this->delimiter);
            $endPart = (strlen($knownIp) == $cutEnd) ? [] : (array) explode($this->delimiter, substr($knownIp, $cutEnd));
            $unfilledBlocks = $this->blocks - (count($beginPart) + count($endPart));
            if ($unfilledBlocks < 0) {
                throw new BanException($this->getLang()->ikbInvalidNumOfBlocksTooMany($knownIp));
            }
            $ipInArray = array_merge($beginPart, array_fill(0, $unfilledBlocks, '0'), $endPart);
        } else {
            $ipInArray = (array) explode($this->delimiter, $knownIp);
        }

        if ($this->blocks != count($ipInArray)) {
            throw new BanException($this->getLang()->ikbInvalidNumOfBlocksAmount($knownIp));
        }

        $ip = clone $this->getBasicIp();
        $ip->setData($this->type, array_map('strval', $ipInArray), $affectedBits);
        return $ip;
    }

    abstract protected function getBasicIp(): Ip;

    abstract protected function getLang(): IKBTranslations;
}

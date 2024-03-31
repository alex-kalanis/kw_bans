<?php

use kalanis\kw_bans\Bans;
use kalanis\kw_bans\Sources;
use kalanis\kw_bans\BanException;


class BasicBansTest extends CommonTestClass
{
    /**
     * @param array $inWhat
     * @param string $looked
     * @param bool $isBasic
     * @param bool $isClearing
     * @throws BanException
     * @dataProvider basicBansProvider
     */
    public function testBasicEntry(array $inWhat, string $looked, bool $isBasic, bool $isClearing): void
    {
        $data = new Bans\Basic(new Sources\Arrays($inWhat));
        $data->setLookedFor($looked);
        $this->assertEquals($isBasic, $data->isBanned());
    }

    /**
     * @param array $inWhat
     * @param string $looked
     * @param bool $isBasic
     * @param bool $isClearing
     * @throws BanException
     * @dataProvider basicBansProvider
     */
    public function testClearingEntry(array $inWhat, string $looked, bool $isBasic, bool $isClearing): void
    {
        $data = new Bans\Clearing(new Sources\Arrays($inWhat));
        $data->setLookedFor($looked);
        $this->assertEquals($isClearing, $data->isBanned());
    }

    public function basicBansProvider(): array
    {
        return [
            [['asdf', 'ghjk', 'qwer', 'tzui', 'yxcv', 'bnml'], 'poiuztrewq', false, false], // not contains
            [['asdf', 'ghjk', 'qwer', 'tzui', 'yxcv', 'bnml'], 'jkqw*ertz', false, true], // must clear
            [['asdf', 'ghjk', 'qwer', 'tzui', 'yxcv', 'bnml'], 'zui', false, false], // short - not found
            [['asdf', 'ghjk', 'qwer', 'tzui', 'yxcv', 'bnml'], 'qwertzuiop', true, true], // lookup in long one
            [['as-df', 'gh-jk', 'qw-er', 'tz-ui', 'yx-cv', 'bn-ml'], 'gh_jk', false, false], // not contains - not exused char
            [['as-df', 'gh-jk', 'qw-er', 'tz-ui', 'yx-cv', 'bn-ml'], 'qw*e', false, false], // not contains even with clearing
            [['as_df', 'gh_jk', 'qw_er', 'tz_ui', 'yx_cv', 'bn_ml'], 'gh_jk', true, true], // not excused char
        ];
    }
}

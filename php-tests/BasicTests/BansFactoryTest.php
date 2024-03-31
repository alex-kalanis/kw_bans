<?php

use kalanis\kw_bans\BanException;
use kalanis\kw_bans\Bans;
use kalanis\kw_bans\Interfaces\IIpTypes;
use kalanis\kw_bans\Sources;


class BansFactoryTest extends CommonTestClass
{
    /**
     * @param int $type
     * @param string $instance
     * @dataProvider basicGetterProvider
     * @throws BanException
     */
    public function testBasicGetter(int $type, string $instance): void
    {
        $data = new Bans\Factory();
        $this->assertInstanceOf($instance, $data->getBan($type, new Sources\Arrays([])));
    }

    public function basicGetterProvider(): array
    {
        return [
            [IIpTypes::TYPE_NAME, '\kalanis\kw_bans\Bans\Clearing'],
            [IIpTypes::TYPE_BASIC, '\kalanis\kw_bans\Bans\Basic'],
            [IIpTypes::TYPE_IP_4, '\kalanis\kw_bans\Bans\IP4'],
            [IIpTypes::TYPE_IP_6, '\kalanis\kw_bans\Bans\IP6'],
        ];
    }

    /**
     * @throws BanException
     */
    public function testBasicGetterFail(): void
    {
        $data = new Bans\Factory();
        $this->expectException(BanException::class);
        $data->getBan(IIpTypes::TYPE_NONE, new Sources\Arrays([]));
    }

    /**
     * @throws BanException
     */
    public function testTypeSelector(): void
    {
        $data = new Bans\Factory();
        $this->assertNotEmpty($data->whichType(new Sources\Arrays([])));
        $this->assertNotEmpty($data->whichType(new Sources\Arrays(['qwer', 'tzui'])));
        $this->assertNotEmpty($data->whichType(['qwer', 'tzui']));
        $this->assertNotEmpty($data->whichType(realpath(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'testfile.txt')));
    }

    /**
     * @param array $inputs
     * @param string $instance
     * @dataProvider typeGetterProvider
     * @throws BanException
     */
    public function testGetterByType(array $inputs, string $instance): void
    {
        $data = new Bans\Factory();
        $this->assertInstanceOf($instance, $data->whichType($inputs));
    }

    public function typeGetterProvider(): array
    {
        return [
            [['qwer', 'tzui', 'asdf', 'ghjk'], '\kalanis\kw_bans\Bans\Clearing'],
            [['qwer*', 'tzui', 'asdf', 'ghjk?'], '\kalanis\kw_bans\Bans\Basic'],
            [['10.0.0.1', '127..1', '10../8'], '\kalanis\kw_bans\Bans\IP4'],
            [['::1', '2001::2001', '2001::/32'], '\kalanis\kw_bans\Bans\IP6'],
        ];
    }

    /**
     * @throws BanException
     */
    public function testTypeFail(): void
    {
        $data = new Bans\Factory();
        $this->expectException(BanException::class);
        $data->whichType(new \stdClass());
    }
}

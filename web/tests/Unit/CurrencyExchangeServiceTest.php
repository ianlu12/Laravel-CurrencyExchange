<?php

namespace Tests\Unit;

use App\Library\Currency\CurrencyFatory;
use PHPUnit\Framework\TestCase;
use App\Services\CurrencyExchangeService;
use App\Library\Currency\CurrencyRate\USD;
use Exception;

class CurrencyExchangeServiceTest extends TestCase
{

    protected static $service;

    public function setUp(): void
    {
        parent::setUp();
        self::$service = new CurrencyExchangeService(new USD);
    }
    /**
     * source系統並不提供
     */
    public function testSourceNotExistException()
    {
        $this->expectExceptionMessage('source is not exist!');
        self::$service = new CurrencyExchangeService(CurrencyFatory::getCurrencyRate('RMB'));
    }

    /**
     * 輸入小數點錯誤
     */
    public function testSetAmountDecimalException()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('amount is not valid!');
        self::$service->setAmount('1.1.1');
    }

    /**
     * 輸入非數字
     */
    public function testSetAmountNotNumberException()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('amount is not valid!');
        self::$service->setAmount('AAA');
    }

    /**
     * 輸入四捨五入至小數點二位
     */
    public function testHandleAmountDecimal()
    {
        $this->assertEquals(self::$service->setAmount('1')->handleAmountDecimal()->amount, '1');
        // 四捨五入測試
        $this->assertEquals(self::$service->setAmount('1.004')->handleAmountDecimal()->amount, '1.00');
        $this->assertEquals(self::$service->setAmount('1.005')->handleAmountDecimal()->amount, '1.01');
        $this->assertEquals(self::$service->setAmount('1.0045')->handleAmountDecimal()->amount, '1.00');
    }

    /**
     * target系統並不提供
     */
    public function testExchangeException()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('target is not exist!');
        self::$service->setAmount('1')->handleAmountDecimal()->exchange('RMB');
    }

    /**
     * USDtoUSD成功情境
     */
    public function testExchange()
    {
        $this->assertEquals(self::$service->setAmount('1000')->handleAmountDecimal()->exchange('USD'), '1000.0');
    }
}

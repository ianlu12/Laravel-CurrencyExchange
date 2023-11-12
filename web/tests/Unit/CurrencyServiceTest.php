<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\CurrencyService;
use Exception;

class CurrencyServiceTest extends TestCase
{

    private CurrencyService $service;
    private $rateData;
    public function setUp(): void
    {
        parent::setUp();
        $this->service = new CurrencyService();
        $this->rateData = $this->service->getRateData('USD');
    }
    /**
     * source系統並不提供
     */
    public function testGetRateData()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('source is not exist!');
        $service = new CurrencyService();
        $service->getRateData('RMB');
    }
    
    /**
     * target系統並不提供
     */
    public function testGetRate()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('target is not exist!');
        $this->service->getRate($this->rateData,'RMB');
    }
    /**
     * 輸入非數字
     */
    public function testValidateAmount()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('amount is not valid!');
        $this->service->validateAmount('AAA');
    }
    
    /**
     * 輸入非數字
     */
    public function testValidateAmount2()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('amount is not valid!');
        $this->service->validateAmount('11.1111');
    }

    /**
     * 輸入四捨五入至小數點二位
     */
    public function handleAmountInput()
    {
        $this->assertEquals($this->service->handleAmountInput('1'), 1);
        // 四捨五入測試
        $this->assertEquals($this->service->handleAmountInput('1.004'), 1.00);
        $this->assertEquals($this->service->handleAmountInput('1.005'), 1.01);
        $this->assertEquals($this->service->handleAmountInput('1.0045'), 1.00);
    }

    /**
     * USDtoUSD成功情境
     */
    public function testExchange()
    {
        $this->assertEquals($this->service->exchange('1000', 1), '1000.0');
    }
}

<?php

namespace App\Services;

use App\Interface\CurrencyRateInterface;
use Exception;

class CurrencyExchangeService
{
    private CurrencyRateInterface $currencyRate;
    public float $amount;

    public function __construct(?CurrencyRateInterface $currencyRate)
    {
        if (!isset($currencyRate)) {
            throw new Exception('source is not exist!', 40004);
        }
        $this->currencyRate = $currencyRate;
    }

    /**
     * 設定金額
     *
     * @param string $amount
     */
    public function setAmount(string $amount)
    {
        $this->amount = $this->checkAmount($amount);
        return $this;
    }

    /**
     * 驗證輸入值
     *
     * @param string $amount
     */
    private function checkAmount(string $amount)
    {
        if (!preg_match('/^\d+$|^\d+[[\.]?[\d]+]?$/', $amount)) {
            throw new Exception('amount is not valid!', 40003);
        }
        return (float)$amount;
    }

    /**
     * 處裡金額小數點
     */
    public function handleAmountDecimal()
    {
        $this->amount = round($this->amount, 2);
        return $this;
    }

    public function toStringWithThousandSeparator()
    {
        return number_format($this->amount, 2);
    }

    /**
     * 使用匯率轉換
     */
    public function exchange(string $currency)
    {
        $rate = $this->currencyRate->getCurrencyRate($currency);
        if (!isset($rate)) {

            throw new Exception('target is not exist!', 40001);
        }
        return $this->amount * $rate;
    }
}

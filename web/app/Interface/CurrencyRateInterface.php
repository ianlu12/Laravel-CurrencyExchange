<?php

namespace App\Interface;

interface CurrencyRateInterface
{
    /**
     * 取得匯率
     *
     * @param string $currency
     */
    public function getCurrencyRate(string $currency);
}

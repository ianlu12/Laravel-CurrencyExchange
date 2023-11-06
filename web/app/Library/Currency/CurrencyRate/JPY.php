<?php

namespace App\Library\Currency\CurrencyRate;

use App\Interface\CurrencyRateInterface;

class JPY implements CurrencyRateInterface
{
    private float $TWD = 0.26956;
    private float $JPY = 1;
    private float $USD = 0.00885;

    public function getCurrencyRate(string $currency)
    {
        return $this->$currency ?? null;
    }
}

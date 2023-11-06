<?php

namespace App\Library\Currency\CurrencyRate;

use App\Interface\CurrencyRateInterface;

class TWD implements CurrencyRateInterface
{
    private float $TWD = 1;
    private float $JPY = 3.669;
    private float $USD = 0.03281;

    public function getCurrencyRate(string $currency)
    {
        return $this->$currency ?? null;
    }
}

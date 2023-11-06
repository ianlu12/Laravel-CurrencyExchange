<?php

namespace App\Library\Currency\CurrencyRate;

use App\Interface\CurrencyRateInterface;

class USD implements CurrencyRateInterface
{
    private float $TWD = 40.444;
    private float $JPY = 111.801;
    private float $USD = 1;

    public function getCurrencyRate(string $currency)
    {
        return $this->$currency ?? null;
    }
}

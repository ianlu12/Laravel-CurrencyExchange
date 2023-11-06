<?php

namespace App\Library\Currency;

use App\Library\Currency\CurrencyRate\TWD;
use App\Library\Currency\CurrencyRate\JPY;
use App\Library\Currency\CurrencyRate\USD;

class CurrencyFatory
{
    public static function getCurrencyRate(string $sourceCurrency)
    {
        $currency = null;

        switch ($sourceCurrency) {
            case 'TWD':
                $currency = new TWD();
                break;
            case 'JPY':
                $currency = new JPY();
                break;
            case 'USD':
                $currency = new USD();
                break;
        }
        return $currency;
    }
}

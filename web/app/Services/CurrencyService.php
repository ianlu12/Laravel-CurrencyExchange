<?php

namespace App\Services;

use Exception;

class CurrencyService
{
    public function getRateData($source)
    {

        $datas = '
            {
                "currencies": {
                    "TWD": {
                        "TWD": 1,
                        "JPY": 3.669,
                        "USD": 0.03281
                    },
                    "JPY": {
                        "TWD": 0.26956,
                        "JPY": 1,
                        "USD": 0.00885
                    },
                    "USD": {
                        "TWD": 30.444,
                        "JPY": 111.801,
                        "USD": 1
                    }
                }
            }';

        // 資料轉物件
        $object = json_decode($datas, false);
        if (!isset($object->currencies->$source)) {
            throw new Exception('source is not exist!', 40001);
        }

        return $object->currencies->$source;
    }

    public function getRate($query, $target)
    {
        if (!isset($query->$target)) {
            throw new Exception('target is not exist!', 40001);
        }

        return (float) $query->$target;
    }

    /**
     * 驗證輸入值
     *
     * @param string $amount
     */
    public function validateAmount(string $amount): string
    {
        if (!preg_match('/^\d{1,3}(?:[.,]\d{3})*(?:[.,]\d{1,2})?$|^\d+(?:[.,]\d{1,2})?$/', $amount)) {
            throw new Exception('amount is not valid!', 40003);
        }
        return $amount;
    }

    /**
     * 處裡金額小數點
     */
    public function handleAmountInput(string $amount): float
    {
        $amount = (float) str_replace(',', '', $amount); // 去除逗點
        $amount = round($amount, 2);
        return $amount;
    }

    public function formatAmount(float $amount): string
    {
        return number_format($amount, 2);
    }

    /**
     * 使用匯率轉換
     */
    public function exchange(float $amount, float $currencyRate): float
    {
        return $amount * $currencyRate;
    }
}

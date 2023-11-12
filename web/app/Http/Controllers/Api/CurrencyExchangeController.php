<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CurrencyExchangeRequest;
use App\Services\CurrencyService;
use Exception;
use Illuminate\Http\Response;

class CurrencyExchangeController extends Controller
{
    private $currencyService;


    public function __construct(CurrencyService $currencyService)
    {
        $this->currencyService = $currencyService;
    }

    public function exchange(CurrencyExchangeRequest $request)
    {
        try {
            // 檢查輸入
            $amount = $this->currencyService->validateAmount($request->amount);
            // 處理輸入(去除逗點)
            $amount = $this->currencyService->handleAmountInput($amount); 
            // 取匯率資料
            $query = $this->currencyService->getRateData($request->source);
            // 取指定國家匯率
            $rate = $this->currencyService->getRate($query, $request->target);
            // 換算
            $exchangedAmount = $this->currencyService->exchange($amount, $rate);
            // 格式化金額
            $outputAmount = $this->currencyService->formatAmount($exchangedAmount);
        } catch (Exception $ex) {

            return response()->json([
                'msg' => $ex->getMessage(),
            ]);
        }

        // 輸出的資料
        $responseArray = [
            'msg' => 'success',
            'amount' => $outputAmount
        ];

        return response()->json($responseArray, Response::HTTP_OK);
    }
}

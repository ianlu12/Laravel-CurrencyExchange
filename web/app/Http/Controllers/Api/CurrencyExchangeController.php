<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CurrencyExchangeRequest;
use App\Services\CurrencyExchangeService;
use Illuminate\Http\Request;
use App\Library\Currency\CurrencyFatory;
use Exception;
use Mockery\Expectation;

class CurrencyExchangeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function exchange(CurrencyExchangeRequest $request)
    {
        $validateData = $request->validated();
        
        $amount = str_replace(',','',$validateData['amount']); // 去除逗點

        $source = $validateData['source'];
        $target = $validateData['target'];

        try {
            $service = new CurrencyExchangeService((CurrencyFatory::getCurrencyRate($source)));
            $outputAmount = $service->setAmount($amount)
                ->handleAmountDecimal()
                ->exchange($target);
        } catch (Exception $ex) {
            return response()->json([
                'msg' => $ex->getMessage(),
            ]);
        }

        return response()->json([
            'msg' => 'success',
            'amount' => number_format($outputAmount, 2) // 四捨五入到小數點二位,千芬位逗點
        ]);
    }
}

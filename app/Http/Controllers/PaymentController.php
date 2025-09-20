<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\Bill;
use App\Models\Song;
use App\Services\PayOSService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
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
    public function store(Request $request, PayOSService $payOSService)
    {
        $param = $request->all();

        try {
            $bill = Bill::create([
                'song_id' => $param['song_id'],
                'order_code' => intval(substr(strval(microtime(true) * 10000), -6)),
                'price' => 10000,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            $song = Song::find($param['song_id']);
            $item = [
                [
                    'name' => $song->name,
                    'quantity' => 1,
                    'price' => $bill->price
                ]
            ];

            $res = $payOSService->createPaymentLink($bill, $item);
            if (is_null($res)) {
                return ApiResponse::dataNotfound();
            }
            $bill->checkout_url = $res['checkoutUrl'];

            return ApiResponse::success($bill);
        } catch (\Throwable $th) {
            Log::error($th);
            return ApiResponse::internalServerError();
        }
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
}

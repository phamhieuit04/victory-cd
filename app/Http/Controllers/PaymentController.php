<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\Bill;
use App\Models\Song;
use App\Services\PayOSService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PaymentController extends Controller
{
    public function index()
    {
        //
    }

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

            // $res = $payOSService->createPaymentLink($bill, $item);
            // if (is_null($res)) {
            //     return ApiResponse::dataNotfound();
            // }
            // $bill->checkout_url = $res['checkoutUrl'];

            // Create VietQR
            $bankBin = "970422"; // MB Bank
            $accountNo = "0823869522";
            $accountName = "NGUYEN THI MINH NGOC";
            $amount = $bill->price;

            $fileName = 'qr_' . $bill->order_code . '.png';

            $qrUrl = "https://img.vietqr.io/image/{$bankBin}-{$accountNo}-compact.png"
                . "?amount={$amount}&accountName=" . urlencode($accountName);

            $qrImage = file_get_contents($qrUrl);

            Storage::disk('public')->put('qrcodes/' . $fileName, $qrImage);

            $bill->code_url = asset('storage/qrcodes/' . $fileName);
            $bill->save();

            return ApiResponse::success($bill);
        } catch (\Throwable $th) {
            Log::error($th);
            return ApiResponse::internalServerError();
        }
    }

    public function show(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
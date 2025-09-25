<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\Bill;
use App\Models\Song;
use App\Services\PayOSService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
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

            $res = $payOSService->createPaymentLink($bill, $item);
            if (is_null($res)) {
                return ApiResponse::dataNotfound();
            }

            $bill->checkout_url = $res['checkoutUrl'];

            // get QR image from VietQR
            $bin = $res['bin'];
            $accountNumber = $res['accountNumber'];
            $accountName = $res['accountName'];
            $amount = $bill->price;
            $description = $res['description'];

            // Create VietQR url
            $qrUrl = "https://img.vietqr.io/image/{$bin}-{$accountNumber}-print.png"
                . "?amount={$amount}"
                . "&addInfo=" . urlencode($description)
                . "&accountName=" . urlencode($accountName);

            $fileName = 'qr_' . $bill->order_code . '.png';
            $qrImage = file_get_contents($qrUrl);

            // Save image to server
            Storage::disk('app')->put('qrcodes/' . $fileName, $qrImage);

            // Return QR image link
            $bill->code_url = env('APP_URL') . '/qrcodes/' . $fileName;
            $bill->save();

            return ApiResponse::success($bill);
        } catch (\Throwable $th) {
            Log::error($th);
            return ApiResponse::internalServerError();
        }
    }

    public function show(PayOSService $payOSService, string $orderCode)
    {
        try {
            if (!$orderCode) {
                return ApiResponse::internalServerError();
            }

            $res = $payOSService->getPaymentStatus($orderCode);

            if (is_null($res)) {
                return ApiResponse::dataNotfound();
            }

            return ApiResponse::success($res['status']);
        } catch (\Throwable $th) {
            Log::error($th);
            return ApiResponse::internalServerError();
        }
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
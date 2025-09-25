<?php

namespace App\Services;

use App\Models\Bill;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use PayOS\PayOS;
use Ramsey\Uuid\Type\Integer;

class PayOSService
{
    private $payOS;

    /**
     * Constructor method to init PayOS config
     */
    public function __construct()
    {
        $this->payOS = new PayOS(
            env('PAYOS_CLIENT_ID'),
            env('PAYOS_API_KEY'),
            env('PAYOS_CHECKSUM_KEY')
        );
    }

    /**
     * Service method to create payment link
     *
     * @param \App\Models\Bill $bill
     */
    public function createPaymentLink(Bill $bill, array $items)
    {
        try {
            $data = [
                'orderCode' => $bill->order_code,
                'amount' => $bill->price,
                'description' => 'Thanh toan hoa don ' . $bill->order_code,
                'items' => $items,
                'returnUrl' => 'http://localhost:8000/paysuccess',
                'cancelUrl' => 'http://localhost:8000/payfail',
                'expiredAt' => now()->addMinutes(10)->timestamp
            ];
            $result = $this->payOS->createPaymentLink($data);

            return $result;
        } catch (\Throwable $th) {
            Log::error($th);
            return null;
        }
    }

    public function getPaymentStatus($orderCode)
    {
        $response = $this->payOS->getPaymentLinkInformation($orderCode);
        return $response;
    }
}
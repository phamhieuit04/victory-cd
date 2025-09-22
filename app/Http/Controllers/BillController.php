<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\Bill;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class BillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $params = $request->input();
            $offset = 0;
            if (isset($params['offset'])) {
                $offset = $params['offset'];
            }
            $bills = Bill::join('songs', 'bills.song_id', 'songs.id')
                ->select([
                    'bills.id',
                    'bills.order_code',
                    'bills.code_url',
                    'bills.price',
                    'bills.status',
                    'bills.updated_at',
                    'songs.name as song_name'
                ])->offset($offset)->limit(10)
                ->get()->each(function ($item) {
                    $item->time_ago = Carbon::parse($item->updated_at)->diffForHumans();
                    unset($item->updated_at);
                });
            return ApiResponse::success([
                'bills' => $bills,
                'total' => Bill::count()
            ]);
        } catch (\Throwable $th) {
            Log::error($th);
            return ApiResponse::internalServerError();
        }
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
    public function update(Request $request, Bill $bill)
    {
        try {
            $bill->status = 'SHIPPED';
            $bill->touch();
            return ApiResponse::success();
        } catch (\Throwable $th) {
            Log::error($th);
            return ApiResponse::internalServerError();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

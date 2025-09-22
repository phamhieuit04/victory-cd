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
    public function index()
    {
        try {
            $bills = Bill::join('songs', 'bills.song_id', 'songs.id')
            ->select([
                'bills.id',
                'bills.order_code',
                'bills.code_url',
                'bills.price',
                'bills.status',
                'bills.updated_at',
                'songs.name as song_name'
            ])->get()->each(function ($item)  {
                $item->time_ago = Carbon::parse($item->updated_at)->diffForHumans();
                unset($item->updated_at);
            });
            return ApiResponse::success([
                'bills' => $bills
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
            $request->validate([
                'status' => ['required', 'string']
            ]);
            $bill->status = $request->input('status');
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

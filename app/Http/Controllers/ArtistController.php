<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ArtistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return ApiResponse::success(
                User::select(['id', 'name'])->get()
            );
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
        try {
            $request->validate([
                'name' => ['required', 'max:255']
            ]);
            $insert = User::insert([
                'name' => $request->input('name'),
                'created_at' => now(),
                'updated_at' => now()
            ]);
            if (!$insert) {
                return ApiResponse::internalServerError();
            }
            return ApiResponse::success();
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
        try {
            $user = User::select(['id', 'name'])->where('id', $id)
                ->with([
                    'songs' => function ($query) {
                        $query->select(['id', 'name', 'thumbnail_url', 'song_url', 'user_id']);
                    }
                ])->first();
            if (blank($user)) {
                return ApiResponse::dataNotfound();
            }
            return ApiResponse::success($user);
        } catch (\Throwable $th) {
            Log::error($th);
            return ApiResponse::internalServerError();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $request->validate([
                'name' => ['required', 'max:255']
            ]);
            $update = User::where('id', $id)->update([
                'name' => $request->input('name')
            ]);
            if (!$update) {
                return ApiResponse::internalServerError();
            }
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
        try {
            User::destroy($id);
            return ApiResponse::success();
        } catch (\Throwable $th) {
            Log::error($th);
            return ApiResponse::internalServerError();
        }
    }
}

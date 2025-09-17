<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\Song;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SongController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $songs = Song::select([
                'songs.id',
                'songs.name',
                'songs.song_url',
                'songs.thumbnail_url',
                'songs.user_id',
                'users.id',
                'users.name as artist_name'
            ])->join('users', 'songs.user_id', 'users.id')->get();
            return ApiResponse::success($songs);
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
                'name' => ['required', 'max:255'],
                'user_id' => ['required'],
                'thumbnail_url' => ['required'],
                'song_url' => ['required']
            ]);
            $insert = Song::insert([
                'name' => $request->input('name'),
                'user_id' => $request->input('user_id'),
                'song_url' => $request->input('song_url'),
                'thumbnail_url' => $request->input('thumbnail_url'),
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
            $song = Song::select([
                'songs.id',
                'songs.name',
                'songs.song_url',
                'songs.thumbnail_url',
                'songs.user_id',
                'users.id',
                'users.name as artist_name'
            ])->where('songs.id', $id)
                ->join('users', 'songs.user_id', 'users.id')
                ->first();
            return ApiResponse::success($song);
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
                'name' => ['required', 'max:255'],
                'thumbnail_url' => ['required']
            ]);
            $update = Song::where('id', $id)->update([
                'name' => $request->input('name'),
                'thumbnail_url' => $request->input('thumbnail_url')
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
            Song::destroy($id);
            return ApiResponse::success();
        } catch (\Throwable $th) {
            Log::error($th);
            return ApiResponse::internalServerError();
        }
    }
}

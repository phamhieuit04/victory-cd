<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UploadController extends Controller
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
        try {
            $request->validate([
                'type' => ['required', 'max:255'],
                'file' => ['file']
            ]);
            $type = $request->input('type');
            if ($type != 'song' && $type != 'thumbnail') {
                return ApiResponse::badRequest();
            }
            if (!$request->hasFile('file')) {
                return ApiResponse::dataNotfound();
            }
            $file = $request->file('file');
            $savePath = public_path('/uploads/') . $type . 's/';
            $fileName = md5(now()) . '_' . $file->getClientOriginalName();
            $file->move($savePath, $fileName);
            $fileUrl = env('APP_URL') . '/uploads/' . $type . 's/' . $fileName;
            return ApiResponse::success(['file_url' => $fileUrl]);
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

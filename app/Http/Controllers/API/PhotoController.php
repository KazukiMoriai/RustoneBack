<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PhotoController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'description' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:50'
        ]);

        try {
            $image = $request->file('image');
            $fileName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            
            // 画像をストレージに保存
            $path = $image->storeAs('photos', $fileName, 'public');
            
            // データベースに保存
            $photo = Photo::create([
                'file_name' => $fileName,
                'file_path' => Storage::url($path),
                'size' => $image->getSize(),
                'description' => $request->description,
                'category' => $request->category
            ]);

            return response()->json([
                'success' => true,
                'message' => '画像がアップロードされました',
                'data' => $photo
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '画像のアップロードに失敗しました',
                'error' => $e->getMessage()
            ], 500);
        }
    }
} 
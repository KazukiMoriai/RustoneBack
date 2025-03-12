<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|max:10240', // 最大10MB
        ]);

        $file = $request->file('photo');
        $path = $file->store('photos', 'public');

        $photo = Photo::create([
            'file_path' => $path,
            'file_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
            'file_size' => $file->getSize(),
        ]);

        return response()->json([
            'message' => '画像がアップロードされました',
            'photo' => $photo
        ], 201);
    }
} 
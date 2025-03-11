<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function store(Request $request)
    {
        if (!$request->hasFile('image')) {
            return response()->json(['error' => '画像が送信されていません。'], 400);
        }

        $file = $request->file('image');
        $path = $file->store('images', 'public');

        return response()->json([
            'success' => true,
            'path' => Storage::url($path)
        ]);
    }
} 
<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\Signature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class PhotoController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|max:10240', // 最大10MB
            // 署名関連のバリデーション追加
            'signature' => 'nullable|string',
            'imageHash' => 'nullable|string',
            'challenge' => 'nullable|string',
            'timestamp' => 'nullable|numeric',
            'wallet_address' => 'nullable|string',
        ]);

        try {
            // トランザクション開始
            return DB::transaction(function () use ($request) {
                // 画像をアップロード（既存のコード）
                $file = $request->file('photo');
                $path = $file->store('photos', 'public');

                // 写真情報をデータベースに保存（既存のコード）
                $photo = Photo::create([
                    'file_path' => $path,
                    'file_name' => $file->getClientOriginalName(),
                    'mime_type' => $file->getMimeType(),
                    'file_size' => $file->getSize(),
                ]);

                // 署名データがある場合は保存（新規追加部分）
                if ($request->has('signature') && $request->has('imageHash')) {
                    Signature::create([
                        'photo_id' => $photo->id,
                        'wallet_address' => $request->input('wallet_address'),
                        'image_hash' => $request->input('imageHash'),
                        'signature' => $request->input('signature'),
                        'challenge' => $request->input('challenge'),
                        'timestamp' => $request->input('timestamp'),
                    ]);
                }

                // レスポンスを返す（既存のコード）
                return response()->json([
                    'message' => '画像がアップロードされました',
                    'photo' => $photo
                ], 201);
            });
        } catch (\Exception $e) {
            // エラー処理
            return response()->json([
                'message' => '画像アップロードに失敗しました: ' . $e->getMessage()
            ], 500);
        }
    }
}
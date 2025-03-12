<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migration.
     */
    public function up(): void
    {
        Schema::create('signatures', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('photo_id');
            $table->string('wallet_address', 42);
            $table->string('image_hash', 66);
            $table->text('signature');
            $table->string('challenge', 255);
            $table->bigInteger('timestamp');
            $table->timestamps();

            // 外部キー制約
            $table->foreign('photo_id')
                  ->references('id')
                  ->on('photos')
                  ->onDelete('cascade');

            // インデックス
            $table->index('wallet_address', 'idx_wallet_address');
            $table->index('image_hash', 'idx_image_hash');
        });
    }

    /**
     * Reverse the migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('signatures');
    }
};
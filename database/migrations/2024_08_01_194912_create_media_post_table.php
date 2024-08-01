<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('media_post', function (Blueprint $table) {
            $table->ulid('post_id');
            $table->ulid('media_id');
            $table->timestamps();

            $table->index(['post_id', 'media_id']);
        });
    }
};

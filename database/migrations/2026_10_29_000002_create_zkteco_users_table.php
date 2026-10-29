<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('zkteco_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('device_id')->constrained('zkteco_devices')->cascadeOnDelete();
            $table->integer('uid');
            $table->string('user_id')->nullable();
            $table->string('name')->nullable();
            $table->string('card')->nullable();
            $table->integer('privilege')->nullable();
            $table->timestamps();
            $table->unique(['device_id','uid']);
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('zkteco_users');
    }
};

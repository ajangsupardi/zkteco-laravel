<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('zkteco_attendance', function (Blueprint $table) {
            $table->id();
            $table->foreignId('device_id')->constrained('zkteco_devices')->cascadeOnDelete();
            $table->integer('uid');
            $table->dateTime('timestamp');
            $table->integer('state')->nullable();
            $table->integer('punch')->nullable();
            $table->timestamps();
            $table->index(['device_id','uid','timestamp']);
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('zkteco_attendance');
    }
};

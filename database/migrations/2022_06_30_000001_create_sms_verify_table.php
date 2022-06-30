<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('sms_verify',
            static function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('phone');
                $table->string('sms_code');
                $table->string('sms_token')->nullable()->index()->unique();
                $table->dateTime('sms_token_expires')->nullable();
                $table->string('action_token')->nullable()->index()->unique();
                $table->dateTime('action_token_expires')->nullable();
                $table->timestamps();
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('sms_verify');
    }
};


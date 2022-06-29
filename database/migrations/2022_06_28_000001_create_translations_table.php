<?php

use App\Models\Localization\Translation;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create(Translation::TABLE,
            static function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('key')->nullable();
                $table->string('text');
                $table->string('place');
                $table->string('lang');
                $table->string('entity_type')->nullable();
                $table->integer('entity_id')->nullable();
                $table->string('group')->nullable();
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists(Translation::TABLE);
    }
};

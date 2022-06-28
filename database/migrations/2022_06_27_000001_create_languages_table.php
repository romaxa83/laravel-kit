<?php

use App\Models\Localization\Language;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create(Language::TABLE,
            static function (Blueprint $table) {
                $table->bigIncrements('id');

                $table->string('name');
                $table->string('native');
                $table->string('slug')->unique();
                $table->string('locale')->unique();
                $table->string('default')->default(false);
                $table->string('active')->default(false);
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists(Language::TABLE);
    }
};

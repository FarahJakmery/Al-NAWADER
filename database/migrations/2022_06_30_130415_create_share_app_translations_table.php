<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShareAppTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('share_app_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('share_app_id')->constrained('share_apps')->onDelete('cascade');
            $table->string('locale')->index();
            $table->string('content');
            $table->unique(['share_app_id', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('share_app_translations');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdvertisementTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advertisement_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->foreignId('advertisement_id')->constrained('advertisement')->onDelete('cascade');
            $table->string('locale')->index();
            $table->string('text');
            $table->unique(['advertisement_id', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('advertisement_translations');
    }
}

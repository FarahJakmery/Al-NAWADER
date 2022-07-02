<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrivacyPolicyTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('privacy_policy_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('privacy_policy_id')->constrained('privacy_policies')->onDelete('cascade');
            $table->string('locale')->index();
            $table->string('content');
            $table->unique(['privacy_policy_id', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('privacy_policy_translations');
    }
}

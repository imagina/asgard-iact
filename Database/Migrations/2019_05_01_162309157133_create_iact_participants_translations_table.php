<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIactParticipantsTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iact__participants_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your translatable fields

            $table->string('title');

            $table->integer('participants_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['participants_id', 'locale']);
            $table->foreign('participants_id')->references('id')->on('iact__participants')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('iact__participants_translations', function (Blueprint $table) {
            $table->dropForeign(['participants_id']);
        });
        Schema::dropIfExists('iact__participants_translations');
    }
}

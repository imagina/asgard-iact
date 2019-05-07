<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIactActTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iact__act_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->string('title');
            $table->string('activities');
            $table->text('description');
            // Your translatable fields

            $table->integer('act_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['act_id', 'locale']);
            $table->foreign('act_id')->references('id')->on('iact__acts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('iact__act_translations', function (Blueprint $table) {
            $table->dropForeign(['act_id']);
        });
        Schema::dropIfExists('iact__act_translations');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIactActParticipantTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iact__act_participant', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('act_id')->unsigned();
            $table->integer('participants_id')->unsigned();
            $table->timestamps();
            $table->foreign('act_id')->references('id')->on('iact__acts')->onDelete('cascade');
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
        Schema::table('iact__act_participant', function (Blueprint $table) {
            $table->dropForeign(['act_id']);
            $table->dropForeign(['participants_id']);
        });
        Schema::dropIfExists('iact__act_participant');
    }
}

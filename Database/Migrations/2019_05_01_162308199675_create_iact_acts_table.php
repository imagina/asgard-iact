<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIactActsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iact__acts', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your fields
            $table->text('options')->default('')->nullable();
            $table->integer('city_id')->default(0)->unsigned();
            $table->text('address');
            $table->integer('user_id')->unsigned();
            $table->text('email');
            $table->integer('phone');

            $table->foreign('user_id')->references('id')->on(config('auth.table', 'users'))->onDelete('restrict');



            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('iact__acts');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRestaurantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurants', function (Blueprint $table) {
            $table->increments('id');
            $table->string('Name');
            $table->string('Arabic_Name');
            $table->string('Phone_Number1');
            $table->string('Phone_Number2');
            $table->string('Phone_Number3');
            $table->string('Recommended_Evaluation');
            $table->string('Status');
            $table->time('Time_Open');
            $table->time('Time_Close');
            $table->boolean('Delivery_Service');
            $table->boolean('Reservation_Service');
            $table->string('Note');
            $table->string('Description');
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
        Schema::dropIfExists('restaurants');
    }
}

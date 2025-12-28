<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserOpenNewAcModelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_open_new_ac_model', function (Blueprint $table) {
            $table->bigIncrements('id'); // Define the primary key explicitly
            $table->unsignedBigInteger('user_id'); // Foreign key for users
            $table->unsignedBigInteger('open_new_ac_model_id'); // Foreign key for open_new_ac_model
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
        Schema::dropIfExists('user_open_new_ac_model');
    }
}

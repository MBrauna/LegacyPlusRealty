<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Parameters extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('split_parameter',function(Blueprint $table){
            $table->increments('id_split_parameter');
            $table->integer('type')->default(0); // [1] - Sales, [2] - Rental
            $table->double('min_value',20,2);
            $table->double('max_value',20,2);
            $table->double('percentual',12,2)->default(0);
            $table->timestamps();
        }); // Schema::create('user_compensation',function(Blueprint $table){ .. });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('split_parameter');
    }
}

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
            $table->text('visual_name');
            $table->text('param_name');
            $table->double('value',20,2);
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

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Archive extends Migration
{
    public function up()
    {
        Schema::create('archive',function(Blueprint $table){
            $table->increments('id_archive');
            $table->integer('id_user')->nullable();
            $table->integer('id_group')->nullable();
            $table->integer('id_contract')->nullable();
            $table->integer('id_user_created');
            $table->text('repository')->nullable();
            $table->boolean('local')->default(false);
            $table->text('name_server')->nullable();
            $table->text('name_file')->nullable();
            $table->text('extension')->nullable();
            $table->text('mime')->nullable();
            $table->double('length',12,2)->nullable();
            $table->timestamps();

            $table->foreign('id_user')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

            $table->index(['id_user']);
            $table->index(['id_group']);
            $table->index(['id_contract']);
            $table->index(['id_user_created']);
            $table->index(['repository']);
            $table->index(['local']);
            $table->index(['local','name_server']);
            $table->index(['local','name_file']);
            $table->index(['extension']);
            $table->index(['length']);
        }); // Schema::create('archive',function(Blueprint $table){ .... });

        Schema::create('quick_access',function(Blueprint $table){
            $table->increments('id_quick_access');
            $table->text('description');
            $table->text('url');
            $table->boolean('status');
            $table->timestamps();

            $table->index(['description']);
            $table->index(['url']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('archive');
        Schema::dropIfExists('quick_access');
    }
}

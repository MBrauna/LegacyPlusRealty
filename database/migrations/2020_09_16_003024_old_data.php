<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class OldData extends Migration
{
    public function up() {
        Schema::create('quick_access',function(Blueprint $table){
            $table->increments('id_quick_access');
            $table->text('description');
            $table->text('url');
            $table->boolean('status');
            $table->timestamps();

            $table->index(['description']);
            $table->index(['url']);
        }); // Schema::create('quick_access',function(Blueprint $table){ ... });

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

        Schema::create('users_group',function(Blueprint $table){
            $table->increments('id_users_group');
            $table->text('description');
            $table->text('icon')->default('fas fa-users');
            $table->boolean('status')->default(true);
            $table->timestamps();

            $table->index(['description']);
            $table->index(['status']);
        }); // Schema::create('archive',function(Blueprint $table){ .... });

        Schema::create('users_group_user',function(Blueprint $table){
            $table->increments('id_users_group_user');
            $table->integer('id_users_group');
            $table->integer('id_user');
            $table->timestamps();

            $table->index(['id_user']);
        }); // Schema::create('archive',function(Blueprint $table){ .... });
    }

    public function down() {
        Schema::dropIfExists('quick_access');
        Schema::dropIfExists('archive');
        Schema::dropIfExists('users_group');
        Schema::dropIfExists('users_group_user');
    }
}

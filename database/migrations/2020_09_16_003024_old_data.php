<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class OldData extends Migration {
    public function up() {
        Schema::create('user_address',function(Blueprint $table){
            $table->increments('id_users_address');
            $table->integer('id_user');
            $table->string('address',150);
            $table->string('city',150);
            $table->string('state',150);
            $table->string('country',150);
            $table->integer('postal_code');
            $table->timestamps();

            $table->foreign('id_user')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

            $table->index(['id_user']);
            $table->index(['address']);
            $table->index(['city']);
            $table->index(['state']);
            $table->index(['country']);
            $table->index(['postal_code']);
        });

        Schema::create('user_phone',function(Blueprint $table){
            $table->increments('id_users_phone');
            $table->integer('id_user');
            $table->integer('ddi')->default(1);
            $table->integer('ddd')->nullable();
            $table->integer('phone');
            $table->timestamps();

            $table->foreign('id_user')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

            $table->index(['id_user']);
            $table->index(['ddi']);
            $table->index(['ddd']);
            $table->index(['phone']);
        });

        Schema::create('user_compensation',function(Blueprint $table){
            $table->increments('id_user_compensation');
            $table->integer('id_user');
            $table->integer('type')->default(0); // [1] - Sales, [2] - Rental
            $table->double('percentual',12,2)->default(0);
            $table->dateTime('init_date');
            $table->deteTime('end_date')->nullable();
            $table->timestamps();

            $table->foreign('id_user')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        }); // Schema::create('user_compensation',function(Blueprint $table){ .. });

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
        }); // Schema::create('quick_access',function(Blueprint $table){ ... });

        Schema::create('group',function(Blueprint $table){
            $table->increments('id_group');
            $table->text('name');
            $table->text('icon')->default('fas fa-users');
            $table->boolean('status')->default(true);
            $table->timestamps();

            $table->index(['name']);
            $table->index(['status']);
        }); // Schema::create('archive',function(Blueprint $table){ .... });

        Schema::create('contract',function(Blueprint $table){
            $table->increments('id_contract');
            $table->integer('type')->default(0); // [0] - Venda, [1] - Aluguel
            $table->dateTime('start_contract');
            $table->dateTime('end_contract')->nullable();
            $table->dateTime('payment_date');
            $table->boolean('payment_exec')->default(false);
            $table->double('value',12,2)->default(0);
            $table->integer('id_user_seller');
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('id_user_seller')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

            $table->index(['type']);
            $table->index(['contract_date']);
            $table->index(['payment_date']);
            $table->index(['payment']);
            $table->index(['id_user_seller']);
        });

        Schema::create('contract_address',function(Blueprint $table){
            $table->increments('id_contract_address');
            $table->integer('id_contract');
            $table->string('address',150);
            $table->string('city',150);
            $table->string('state',150);
            $table->string('country',150);
            $table->integer('postal_code');
            $table->timestamps();

            $table->foreign('id_contract')->references('id_contract')->on('contract')->onUpdate('cascade')->onDelete('cascade');

            $table->index(['id_contract']);
            $table->index(['address']);
            $table->index(['city']);
            $table->index(['state']);
            $table->index(['country']);
            $table->index(['postal_code']);
        });

        Schema::create('contract_phone',function(Blueprint $table){
            $table->increments('id_users_phone');
            $table->integer('id_user');
            $table->integer('ddi')->default(1);
            $table->integer('ddd')->nullable();
            $table->integer('phone');
            $table->timestamps();

            $table->foreign('id_contract')->references('id_contract')->on('contract')->onUpdate('cascade')->onDelete('cascade');

            $table->index(['id_contract']);
            $table->index(['ddi']);
            $table->index(['ddd']);
            $table->index(['phone']);
        });

        Schema::create('payment',function(Blueprint $table){
            $table->increments('id_payment');
            $table->integer('id_contract');
            $table->integer('id_user');
            $table->double('value',12,2)->default(0);
            $table->double('value_aditional',12,2)->default(0);
            $table->double('comission',8,2)->default(0);
            $table->double('percent_group',8,2)->default(0);
            $table->double('percent_tree',8,2)->default(0);
            $table->dateTime('payment_date');
            $table->timestamps();

            $table->index(['id_contract']);
            $table->index(['id_user']);
            $table->index(['payment_date']);

            $table->foreign('id_contract')->references('id_contract')->on('contract')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_user')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });

    } // public function up() { ... }

    public function down() {
        Schema::dropIfExists('user_address');
        Schema::dropIfExists('user_phone');
        Schema::dropIfExists('user_compensation');
        Schema::dropIfExists('archive');
        Schema::dropIfExists('quick_access');
        Schema::dropIfExists('group');
        Schema::dropIfExists('contract');
        Schema::dropIfExists('contract_address');
        Schema::dropIfExists('contract_phone');
        Schema::dropIfExists('payment');

    } // public function down() { ... }
}

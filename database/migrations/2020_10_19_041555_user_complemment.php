<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    class UserComplemment extends Migration
    {
        public function up()
        {
            Schema::create('user_phone', function(Blueprint $table){
                $table->increments('id_user_phone');
                $table->integer('id_user');
                $table->text('references');
                $table->text('phone');

                $table->index('phone');
                $table->foreign('id_user')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            });
            
            
            Schema::create('user_address',function(Blueprint $table){
                $table->increments('id_user_address');
                $table->integer('id_user');
                $table->text('address');
                $table->text('city');
                $table->text('state');
                $table->text('country');
                $table->integer('zip_code');
                $table->timestamps();

                $table->foreign('id_user')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

                $table->index(['id_user']);
                $table->index(['address']);
                $table->index(['city']);
                $table->index(['state']);
                $table->index(['country']);
                $table->index(['zip_code']);
            });

            Schema::create('user_compensation',function(Blueprint $table){
                $table->increments('id_user_compensation');
                $table->integer('id_user');
                $table->integer('id_transaction_type')->default(0); // [1] - Sales, [2] - Rental
                $table->double('min_value',20,2);
                $table->double('max_value',20,2);
                $table->double('percentual',12,2)->default(0);
                $table->timestamps();

                $table->foreign('id_user')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
                $table->foreign('id_transaction_type')->references('id_transaction_type')->on('transaction_type')->onUpdate('cascade')->onDelete('cascade');
            }); // Schema::create('user_compensation',function(Blueprint $table){ .. });

            Schema::create('group',function(Blueprint $table){
                $table->increments('id_group');
                $table->text('name');
                $table->text('icon')->default('fas fa-users');
                $table->boolean('status')->default(true);
                $table->timestamps();

                $table->index(['name']);
                $table->index(['status']);
            }); // Schema::create('archive',function(Blueprint $table){ .... });

            Schema::create('group_user',function(Blueprint $table){
                $table->increments('id_group_user');
                $table->integer('id_group');
                $table->integer('id_user');
                $table->timestamps();

                $table->foreign('id_user')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
                $table->foreign('id_group')->references('id_group')->on('group')->onUpdate('cascade')->onDelete('cascade');

                $table->index(['id_group']);
                $table->index(['id_user']);
            }); // Schema::create('archive',function(Blueprint $table){ .... });
        }

        public function down()
        {
            Schema::dropIfExists('user_phone');
            Schema::dropIfExists('user_address');
            Schema::dropIfExists('user_compensation');
            Schema::dropIfExists('group');
            Schema::dropIfExists('group_user');
        }
    }

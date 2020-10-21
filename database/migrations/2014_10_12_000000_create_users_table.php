<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_type', function(Blueprint $table){
            $table->increments('id_user_type');
            $table->string('description')->default('NOT DEFINED');
            $table->boolean('status');
            $table->timestamps();
        });

        Schema::create('transaction_type', function(Blueprint $table){
            $table->increments('id_transaction_type');
            $table->string('description')->default('NOT DEFINED');
            $table->boolean('status');
            $table->timestamps();
        });

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('photo')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->integer('id_user_recommend')->nullable();
            $table->integer('id_user_type');
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('license_date')->nullable();
            $table->string('license_due')->nullable();
            $table->rememberToken();
            $table->timestamps();

            $table->index('name');
            $table->index('email');
            $table->index('photo');
            $table->index('id_user_recommend');
            $table->index('id_user_type');
            $table->index('first_name');
            $table->index('middle_name');
            $table->index('last_name');

            $table->foreign('id_user_recommend')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_user_type')->references('id_user_type')->on('user_type')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaction_type');
        Schema::dropIfExists('users_type');
        Schema::dropIfExists('users');
    }
}

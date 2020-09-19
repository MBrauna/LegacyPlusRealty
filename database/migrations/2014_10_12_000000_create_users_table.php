<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up() {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->text('photo')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->text('license')->nullable();
            $table->string('password');
            $table->integer('id_user_recommend')->nullable();
            $table->boolean('admin')->default(false);
            $table->boolean('broker')->default(false);
            $table->boolean('realtor')->default(false);
            $table->double('percent',12,2)->default(0);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('users');
    }
}

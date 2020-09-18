<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    class Tree extends Migration
    {
        public function up()
        {
            Schema::create('tree_comission', function (Blueprint $table) {
                $table->increments('id_tree_comission');
                $table->integer('id_tree_comission_prev')->nullable();
                $table->integer('id_user');
                $table->double('percent',8,2);
                $table->timestamps();
                $table->foreign('id_tree_comission_prev')->references('id_tree_comission')->on('tree_comission')->onUpdate('cascade')->onDelete('cascade');

                $table->index(['id_user']);
            });
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down()
        {
            Schema::dropIfExists('tree_comission');
        }
    }

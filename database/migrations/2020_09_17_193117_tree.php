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

            Schema::create('contract',function(Blueprint $table){
                $table->increments('id_contract');
                $table->integer('type')->default(0); // [0] - Venda, [1] - Aluguel
                $table->dateTime('contract_date');
                $table->dateTime('payment_date');
                $table->boolean('payment')->default(false);
                $table->double('value',8,2)->default(0);
                $table->integer('id_user_sale');
                $table->integer('id_housing')->nullable();
                $table->text('address')->nullable();

                $table->index(['type']);
                $table->index(['contract_date']);
                $table->index(['payment_date']);
                $table->index(['payment']);
                $table->index(['id_user_sale']);
                $table->index(['id_housing']);
            });


            Schema::create('payment',function(Blueprint $table){
                $table->increments('id_payment');
                $table->integer('id_contract');
                $table->integer('id_user');
                $table->double('value',8,2)->default(0);
                $table->double('value_aditional',8,2)->default(0);
                $table->double('comission',8,2)->default(0);
                $table->double('percent_group',8,2)->default(0);
                $table->double('percent_tree',8,2)->default(0);
                $table->dateTime('payment_date');

                $table->index(['id_contract']);
                $table->index(['id_user']);
                $table->index(['payment_date']);

                $table->foreign('id_contract')->references('id_contract')->on('contract')->onUpdate('cascade')->onDelete('cascade');
                $table->foreign('id_user')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
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
            Schema::dropIfExists('contract');
            Schema::dropIfExists('payment');
        }
    }

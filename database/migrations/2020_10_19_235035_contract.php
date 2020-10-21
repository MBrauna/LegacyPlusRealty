<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    class Contract extends Migration
    {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::create('contract',function(Blueprint $table){
                $table->increments('id_contract');
                $table->integer('id_transaction_type')->default(0); // [0] - Venda, [1] - Aluguel
                $table->dateTime('start_contract');
                $table->dateTime('end_contract')->nullable();
                $table->dateTime('payment_date')->nullable();
                $table->boolean('payment_exec')->default(false);
                $table->double('value',12,2)->default(0);
                $table->integer('id_user_seller');
                $table->text('description')->nullable();
                $table->timestamps();

                $table->foreign('id_user_seller')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
                $table->foreign('id_transaction_type')->references('id_transaction_type')->on('transaction_type')->onUpdate('cascade')->onDelete('cascade');

                $table->index(['id_transaction_type']);
                $table->index(['start_contract']);
                $table->index(['end_contract']);
                $table->index(['payment_date']);
                $table->index(['payment_exec']);
                $table->index(['id_user_seller']);
            });

            Schema::create('contract_address',function(Blueprint $table){
                $table->increments('id_contract_address');
                $table->integer('id_contract');
                $table->text('address')->nullable();
                $table->text('city')->nullable();
                $table->text('state')->nullable();
                $table->text('country')->nullable();
                $table->integer('zip_code')->nullable();
                $table->timestamps();

                $table->foreign('id_contract')->references('id_contract')->on('contract')->onUpdate('cascade')->onDelete('cascade');

                $table->index(['id_contract']);
                $table->index(['address']);
                $table->index(['city']);
                $table->index(['state']);
                $table->index(['country']);
                $table->index(['zip_code']);
            });

            Schema::create('contract_phone',function(Blueprint $table){
                $table->increments('id_contract_phone');
                $table->integer('id_contract');
                $table->text('reference')->nullable();
                $table->bigInteger('phone')->nullable();
                $table->timestamps();

                $table->foreign('id_contract')->references('id_contract')->on('contract')->onUpdate('cascade')->onDelete('cascade');

                $table->index(['id_contract']);
                $table->index(['phone']);
            });
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down()
        {
            Schema::dropIfExists('contract');
            Schema::dropIfExists('contract_address');
            Schema::dropIfExists('contract_phone');
        }
    }

<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    class Payment extends Migration
    {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::create('payment',function(Blueprint $table){
                $table->increments('id_payment');
                $table->dateTime('processing_date');
                $table->dateTime('payment_date');
                $table->integer('id_contract');
                $table->integer('id_user');
                $table->double('percentual',12,2)->default(0);
                $table->double('value_total',12,2)->default(0);
                $table->double('value_split',12,2)->default(0);
                $table->timestamps();

                $table->index('processing_date');
                $table->index('payment_date');
                $table->index('id_contract');
                $table->index('id_user');

                $table->foreign('id_user')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
                $table->foreign('id_contract')->references('id_contract')->on('contract')->onUpdate('cascade')->onDelete('cascade');
            });

            Schema::create('payment_additional', function(Blueprint $table){
                $table->increments('id_payment_additional');
                $table->dateTime('processing_date');
                $table->dateTime('payment_date');
                $table->integer('id_contract')->nullable();
                $table->integer('id_user');
                $table->integer('id_user_payment');
                $table->double('value',12,2)->default(0);
                $table->timestamps();

                $table->index('processing_date');
                $table->index('payment_date');
                $table->index('id_user_payment');
                $table->index('id_user');

                $table->foreign('id_contract')->references('id_contract')->on('contract')->onUpdate('cascade')->onDelete('cascade');
                $table->foreign('id_user')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
                $table->foreign('id_user_payment')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            });
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down()
        {
            Schema::dropIfExists('payment');
            Schema::dropIfExists('payment_additional');
        }
    }

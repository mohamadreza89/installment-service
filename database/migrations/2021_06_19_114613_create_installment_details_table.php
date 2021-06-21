<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstallmentDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('installment_details', function (Blueprint $table) {
            $table->id();

            $table->bigInteger("installment_id")->unsigned();
            $table->foreign("installment_id")->references("id")->on("installments");

            $table->string("installment_type")->nullable();
//            $table->bigInteger("main")->nullable();
//            $table->bigInteger("vat")->nullable();
//            $table->bigInteger("delivery")->nullable();
            $table->bigInteger("price")->nullable();
            $table->bigInteger("store_id")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('installment_details');
    }
}

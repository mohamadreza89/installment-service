<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstallmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('installments', function (Blueprint $table) {
            $table->id();

            $table->bigInteger("order_id")->unsigned();
            $table->foreign("order_id")->on("orders")->references("id");

            //$table->bigInteger("total_price");
            $table->string("due_date")->nullable();

            $table->integer("turn");

            $table->enum("status", ["unpaid", "paid"])->default("unpaid");
            $table->dateTime("paid_at")->nullable();
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
        Schema::dropIfExists('installments');
    }
}

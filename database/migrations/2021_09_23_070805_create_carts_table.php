<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('uid');
            $table->integer('prodid');
            $table->string('orderid');
            $table->string('option')->nullable();
            $table->string('quantity')->default('0');
            $table->string('price');
            $table->string('discount');
            $table->string('status')->default('cart');
            $table->timestamps();

            //$table->foreign('uid')->references('id')->on('users');
            //$table->foreign('prodid')->references('id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('carts');
    }
}

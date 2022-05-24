<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('uid');
            $table->integer('supplierid')->nullable();
            $table->integer('poid')->nullable();
            $table->string('sku')->nullable();
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->text('description')->nullable();
            $table->string('excerpt')->nullable();
            $table->string('cp')->default('0');
            $table->string('wp')->default('0');
            $table->string('op')->default('0');
            $table->string('sp')->default('0');
            $table->string('quantity')->default('0');
            $table->string('sold')->default('0');
            $table->integer('order')->nullable();
            $table->string('images', 255)->nullable();
            $table->string('status')->default('publish');
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
        Schema::dropIfExists('products');
    }
}

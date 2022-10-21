<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('product_category_id');
            $table->unsignedBigInteger('product_supplier_id');
            $table->string('name');
            $table->text('detail');
            $table->decimal('price_buy',14,5);
            $table->decimal('price_sell',14,5);
            $table->integer('stok');
            $table->text('image');


            $table->foreign('product_category_id')
                ->references('id')
                ->on('product_categories')
                ->onUpdate(DB::raw('NO ACTION'))
                ->onDelete(DB::raw('NO ACTION'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_logs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->integer('in')->nullable();
            $table->integer('out')->nullable();
            $table->decimal('total');
            $table->text('detail')->nullable();


            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onUpdate(DB::raw('NO ACTION'))
                ->onDelete(DB::raw('NO ACTION'));

            $table->foreign('supplier_id')
                ->references('id')
                ->on('suppliers')
                ->onUpdate(DB::raw('NO ACTION'))
                ->onDelete(DB::raw('NO ACTION'));

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
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
        Schema::dropIfExists('stock_logs');
    }
}

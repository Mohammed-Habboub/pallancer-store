<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
             // 1 - many Relationships On the level DataBase
             $table->id();
             $table->foreignId('category_id')->nullable()->constrained('categories', 'id')->nullOnDelete();
             $table->foreignId('store_id')->constrained('stores', 'id')->cascadeOnDelete();
             $table->string('name');
             $table->string('slug')->unique();
             $table->string('image')->nullable();
             $table->unsignedFloat('price')->default(0);
             $table->unsignedFloat('sale_price')->default(0);
             $table->unsignedInteger('quantity')->default(0);
             $table->text('description')->nullable();
             $table->enum('status', ['in-stok', 'sold-out', 'draft']);
             $table->unsignedBigInteger('views')->default(0);
             $table->unsignedBigInteger('sales')->default(0);
             $table->unsignedFloat('rating')->default(0);
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

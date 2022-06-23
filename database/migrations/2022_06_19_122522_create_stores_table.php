<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            // id: BIGINT - PRMATY KEY - AUTO_INCREMENT - UNSIGNED - NOT NULL
            $table->id();

            // name VARCHAR(255) NOT NULL
            $table->string('name');
            $table->string('slug')->unique();
            $table->char('currency', 3)->default('USD');
            $table->char('locale', 2)->default('en');
            $table->string('logo')->nullable();
            $table->text('description')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');

            // creat_at TIMESTAMPS, updated_at TIMESTAMPS
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
        Schema::dropIfExists('stores');
    }
}

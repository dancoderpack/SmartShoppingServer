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
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('title', 256)->unique();
            $table->text('description');
            $table->string('image', 128);
            $table->float('rate');
            $table->json('rate_details');
            $table->string('research_document', 128);
            $table->json('advantages');
            $table->json('disadvantages');
            $table->json('details');
            $table->string('price', 64);
            $table->string('barcode', 16);
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

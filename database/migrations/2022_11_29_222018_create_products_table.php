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

            $table->id();

            $table->string('name');

            $table->text('description')->nullable();

            $table->foreignIdFor(\App\Models\Types::class);

            $table->foreignIdFor(\App\Models\User::class, 'created_by');

            $table->string('status')->default('draft');

            $table->foreignIdFor(\App\Models\Products::class, 'parent_id')->nullable();

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

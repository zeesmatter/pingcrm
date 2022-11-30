<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();

            $table->string('name');

            $table->string('email')->nullable();

            $table->foreignIdFor(\App\Models\Customers::class, 'parent_id')->nullable();

            $table->boolean('subscribed')->default(true)->nullable();

            $table->jsonb('data')->nullable();

            $table->string('status')->default('active')->nullable();

            $table->timestamps();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}

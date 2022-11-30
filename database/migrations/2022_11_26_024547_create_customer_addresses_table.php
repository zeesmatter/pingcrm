<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_addresses', function (Blueprint $table) {

            $table->id();

            $table->foreignIdFor(\App\Models\Customers::class);

            $table->string('street_number')->nullable();

            $table->string('street_name')->nullable();

            $table->string('area')->nullable();

            $table->string('city')->nullable();

            $table->string('postal_code')->nullable();

            $table->text('notes')->nullable();

            $table->string('state')->nullable();

            $table->string('country')->nullable();

            $table->string('lat')->nullable();

            $table->string('lng')->nullable();

            $table->text('google_address_id')->nullable();

            $table->jsonb('data')->nullable();

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
        Schema::dropIfExists('customer_addresses');
    }
}

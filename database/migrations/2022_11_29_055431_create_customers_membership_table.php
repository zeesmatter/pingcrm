<?php

use App\Models\Customers;
use App\Models\Memberships;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersMembershipTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers_memberships', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(Customers::class);

            $table->foreignIdFor(Memberships::class);

            $table->dateTime('start_at')->nullable();

            $table->dateTime('expire_at')->nullable();

            $table->boolean('status')->default(true);

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
        Schema::dropIfExists('customers_membership');
    }
}

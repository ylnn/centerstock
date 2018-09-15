<?php

use App\Order;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('customer_id');
            $table->unsignedInteger('user_id');
            $table->enum('status', Order::STATUS)->default('OPEN');
            $table->unsignedDecimal('sub_total', 8, 2)->default(0);
            $table->unsignedDecimal('tax', 8, 2)->default(0);
            $table->unsignedDecimal('total', 8, 2)->default(0);
            $table->text('shipment_info')->nullable();
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
        Schema::dropIfExists('orders');
    }
}

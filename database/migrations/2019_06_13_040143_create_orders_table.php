<?php

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
            $table->increments('order_id');
            $table->char('code', 9)->unique();
            $table->unsignedInteger('member_user_id')->index();
            $table->unsignedInteger('member_address_id')->index();

            $table->unsignedInteger('shipping_cost');

            $table->string('phone', 20);
            $table->char('province_id', 2)->index();
            $table->char('regency_id', 4)->index();
            $table->char('district_id', 7)->index();
            $table->char('subdistrict_id', 10)->index();
            $table->string('address');

            $table->enum('status', [
                'pending',
                'processing',
                'shipping',
                'finish',
                'canceled',
                'expired',
            ])->default('pending');

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

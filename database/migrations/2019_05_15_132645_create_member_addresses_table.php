<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemberAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_addresses', function (Blueprint $table) {
            $table->increments('member_address_id');
            $table->unsignedInteger('user_id')->index();
            $table->string('name', 60);
            $table->string('phone', 20);
            $table->char('province_id', 2)->index();
            $table->char('regency_id', 4)->index();
            $table->char('district_id', 6)->index();
            $table->char('subdistrict_id', 8)->index();
            $table->string('address');
            $table->boolean('is_default')->default(0);
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
        Schema::dropIfExists('member_addresses');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSimilaritiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('similarities', function (Blueprint $table) {
            $table->increments('similarity_id');
            $table->unsignedInteger('book_id_1')->index();
            $table->unsignedInteger('book_id_2')->index();
            $table->float('similarity');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('similarities');
    }
}

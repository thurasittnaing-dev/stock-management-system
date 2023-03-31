<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDamageHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('damage_histories', function (Blueprint $table) {
            $table->id();
            $table->integer('withdrawer_id');
            $table->integer('stock_id');
            $table->integer('qty');
            $table->text('remark')->remark();
            $table->integer('location_id');
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
        Schema::dropIfExists('damage_histories');
    }
}
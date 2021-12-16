<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('tid');
            $table->string('source');
            $table->string('destination');
            $table->integer('lane');
            $table->string('vehicle_no');
            $table->string('vtype');
            $table->string('seal');
            $table->string('driver');
            $table->string('transporter');
            $table->string('lr');
            $table->string('product')->nullable();
            $table->string('invoice')->nullable();
            $table->string('idate')->nullable();
            $table->tinyInteger('status');
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
        Schema::dropIfExists('transactions');
    }
}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBluetoothSamplesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bluetooth_samples', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uuid');
            $table->integer('major');
            $table->integer('minor');
            $table->decimal('rssi',5,2);
            $table->integer('fingerprint_id')->unsigned();
            $table->foreign('fingerprint_id')->references('id')->on('fingerprints')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('bluetooth_samples');
    }
}

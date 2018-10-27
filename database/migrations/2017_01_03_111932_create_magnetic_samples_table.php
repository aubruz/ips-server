<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMagneticSamplesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('magnetic_samples', function (Blueprint $table) {
            $table->increments('id');
            $table->float('x');
            $table->float('y');
            $table->float('z');
            $table->float('north');
            $table->float('sky');
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
        Schema::dropIfExists('magnetic_samples');
    }
}

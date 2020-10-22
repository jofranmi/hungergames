<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tributes', function (Blueprint $table) {
            $table->id();
            $table->string('friendly_name');
            $table->string('name');
            $table->integer('district');
            $table->integer('aggressiveness');
            $table->integer('power_initial')->default(0);
            $table->integer('power')->default(0);
            $table->integer('power_roll')->nullable();
            $table->integer('kills')->nullable();
            $table->boolean('dead');
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
        Schema::dropIfExists('tributes');
    }
}

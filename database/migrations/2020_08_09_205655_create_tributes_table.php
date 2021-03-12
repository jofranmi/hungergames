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
            $table->integer('aggressiveness')->default(50);
            $table->integer('power_initial')->default(0);
            $table->integer('power')->default(0);
            $table->integer('power_roll')->default(0);
            $table->integer('kills')->default(0);
            $table->boolean('dead')->default(0);
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

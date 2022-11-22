<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('events', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->date('start_date')->nullable();
        $table->date('end_date')->nullable();
        $table->integer('occurrences')->nullable();
        $table->enum('repeat_every', ['Day', 'Week', 'Month', 'Year']);
        $table->enum('day_repeat', ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'])->nullable();
        $table->integer('frequency')->nullable();
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
      Schema::dropIfExists('events');
    }
};

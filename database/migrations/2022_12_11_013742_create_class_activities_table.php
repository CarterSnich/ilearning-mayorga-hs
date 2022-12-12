<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_activities', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            // class
            $table->foreignId('mclass_id')->nullable();
            $table->foreign('mclass_id')->references('id')->on('mclasses')->nullOnDelete();

            $table->string('title');
            $table->json('instructions')->nullable();
            $table->string('module')->nullable();
            $table->integer('score');
            $table->date('deadline');
            $table->boolean('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('class_activities');
    }
}

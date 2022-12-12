<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('submissions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            // student ID
            $table->foreignId('student_id')->nullable();
            $table->foreign('student_id')->references('id')->on('students')->nullOnDelete();

            // class activity ID
            $table->foreignId('activity_id')->nullable();
            $table->foreign('activity_id')->references('id')->on('class_activities')->nullOnDelete();

            $table->string('file')->nullable();
            $table->unsignedInteger('score')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('submissions');
    }
}

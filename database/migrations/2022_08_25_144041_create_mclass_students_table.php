<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMclassStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mclass_students', function (Blueprint $table) {
            $table->id();

            // class
            $table->foreignId('mclass_id');
            $table->foreign('mclass_id')->references('id')->on('mclasses')->cascadeOnDelete();

            // student
            $table->foreignId('student_id');
            $table->foreign('student_id')->references('id')->on('students')->cascadeOnDelete();

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
        Schema::dropIfExists('mclass_students');
    }
}

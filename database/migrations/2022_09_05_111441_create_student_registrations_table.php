<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_registrations', function (Blueprint $table) {
            $table->id();

            // credentials
            $table->string('username')->unique();
            $table->string('password');

            // name
            $table->string('lastname');
            $table->string('firstname');
            $table->string('middlename')->nullable();

            // contact information
            $table->string('email')->unique()->nullable();
            $table->string('phone_number')->unique();

            // enrollment information
            $table->string('section');
            $table->enum('year_level', [7, 8, 9, 10, 11, 12]);

            // registration information
            $table->enum('status', ['pending', 'enrolled', 'rejected'])->default('pending');

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
        Schema::dropIfExists('student_registrations');
    }
}

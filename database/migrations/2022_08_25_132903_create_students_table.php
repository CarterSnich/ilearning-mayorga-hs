<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();

            // credentials
            $table->string('username')->unique();
            $table->string('password');

            // name
            $table->string('lastname');
            $table->string('firstname');
            $table->string('middlename')->nullable();

            // basic information
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->date('date_of_birth')->default(null)->nullable();
            $table->string('address')->nullable();

            // contact information
            $table->string('email')->unique()->nullable();
            $table->string('phone_number')->unique();

            // enrollment information
            $table->string('section');
            $table->enum('year_level', [7, 8, 9, 10, 11, 12]);

            // picture
            $table->string('picture')->nullable();
            $table->boolean('activated')->default(false);

            $table->timestamps();
            $table->rememberToken();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
}

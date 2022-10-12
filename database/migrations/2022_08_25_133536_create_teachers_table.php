<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();

            // credentials
            $table->string('teacher_id')->unique();
            $table->string('password');

            // name
            $table->string('lastname');
            $table->string('firstname');
            $table->string('middlename')->nullable();

            // basic information
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('address')->nullable();

            // contact information
            $table->string('email')->nullable();
            $table->string('phone_number')->nullable();

            // picture
            $table->string('picture')->nullable();

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
        Schema::dropIfExists('teachers');
    }
}

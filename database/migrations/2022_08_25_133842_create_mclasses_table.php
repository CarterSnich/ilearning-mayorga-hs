<?php

use App\Models\Mclass;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMclassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mclasses', function (Blueprint $table) {
            $table->id();


            $table->string('name');
            $table->string('subject');
            $table->text('description')->nullable();

            $table->foreignId('teacher')->nullable();
            $table->foreign('teacher')->references('id')->on('teachers')->nullOnDelete();


            $table->enum('class_color', Mclass::$colors)->default(Mclass::$colors[0]);
            $table->string('code', '7');

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
        Schema::dropIfExists('mclasses');
    }
}

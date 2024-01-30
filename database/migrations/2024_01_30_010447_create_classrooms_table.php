<?php


use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassroomsTable extends Migration
{
    public function up()
    {
        Schema::create('classrooms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('capacity')->nullable();
            $table->timestamps();
        });

        Schema::create('classroom_student', function (Blueprint $table) {
            $table->foreignId('classroom_id')->constrained();
            $table->foreignId('student_id')->constrained();
            $table->primary(['classroom_id', 'student_id']);
        });

        Schema::create('classroom_teacher', function (Blueprint $table) {
            $table->foreignId('classroom_id')->constrained();
            $table->foreignId('teacher_id')->constrained();
            $table->primary(['classroom_id', 'teacher_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('classroom_student');
        Schema::dropIfExists('classroom_teacher');
        Schema::dropIfExists('classrooms');
    }
}

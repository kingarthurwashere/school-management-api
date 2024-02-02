<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('surname');
            $table->string('student_num')->unique();
            $table->date('birth_date');
            $table->text('address');
            $table->string('parent_phone_number');
            $table->string('second_phone_number')->nullable();
            $table->string('gender');
            $table->foreignId('classroom_id')->constrained();
            $table->date('enrollment_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};

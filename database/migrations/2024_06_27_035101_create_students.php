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
        Schema::create('students', function (Blueprint $table) {
            $table->id('id_student');
            $table->unsignedBigInteger('course_id');
            $table->string('cip_student');
            $table->string('code_student')->unique();
            $table->string('course_student');
            $table->string('name_student');
            $table->string('score_student');
            $table->string('url_student');
            $table->string('email_student');
            $table->integer('status_mail')->default(0);
            $table->timestamps();


            $table->foreign('course_id')->references('id_course')->on('course')->onDelete('cascade');
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
};

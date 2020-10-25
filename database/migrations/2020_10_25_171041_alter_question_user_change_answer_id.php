<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterQuestionUserChangeAnswerId extends Migration
{
    public function up()
    {
        Schema::table('question_user', function (Blueprint $table) {
            $table->json('answer_id')->change();
        });
    }

    public function down()
    {
        Schema::table('question_user', function (Blueprint $table) {
            $table->integer('answer_id')->change();
        });
    }
}

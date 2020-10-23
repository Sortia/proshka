<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterLessonsChangeTime extends Migration
{
    public function up()
    {
        Schema::table('lessons', function (Blueprint $table) {
            $table->integer('time')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('lessons', function (Blueprint $table) {
            $table->integer('time')->change();
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterLessonUserAddAdditionalPointColumn extends Migration
{
    public function up()
    {
        Schema::table('lesson_user', function (Blueprint $table) {
            $table->integer('additional_point')->after('text')->nullable();
        });
    }

    public function down()
    {
        Schema::table('lesson_user', function (Blueprint $table) {
            $table->dropColumn('additional_point');
        });
    }
}

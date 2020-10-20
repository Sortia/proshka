<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterLessonsAddParentsDescriptionColumn extends Migration
{
    public function up()
    {
        Schema::table('lessons', function (Blueprint $table) {
            $table->string('parents_description');
        });
    }

    public function down()
    {
        Schema::table('lessons', function (Blueprint $table) {
            $table->dropColumn('parents_description');
        });
    }
}

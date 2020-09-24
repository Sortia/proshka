<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterLessonsAddComplexityTimeAndAvaliableAtColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lessons', function (Blueprint $table) {
            $table->float('complexity')->after('bonus');
            $table->integer('time')->after('complexity');
            $table->integer('available_at')->after('time');
            $table->longText('task')->after('text')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lessons', function (Blueprint $table) {
            $table->dropColumn('complexity');
            $table->dropColumn('time');
            $table->dropColumn('available_at');
            $table->dropColumn('task');
        });
    }
}

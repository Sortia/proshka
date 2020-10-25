<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAnswersAddOrderNumber extends Migration
{
    public function up()
    {
        Schema::table('answers', function (Blueprint $table) {
            $table->integer('order_number')->after('is_right');
        });
    }

    public function down()
    {
        Schema::table('answers', function (Blueprint $table) {
            $table->dropColumn('order_number');
        });
    }
}

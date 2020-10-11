<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeDirectionsAddOrderColumn extends Migration
{
    public function up()
    {
        Schema::table('directions', function (Blueprint $table) {
            $table->integer('order')->after('description');
        });
    }

    public function down()
    {
        Schema::table('directions', function (Blueprint $table) {
            $table->dropColumn('order');
        });
    }
}

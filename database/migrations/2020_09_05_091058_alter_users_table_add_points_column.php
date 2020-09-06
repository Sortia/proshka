<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUsersTableAddPointsColumn extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('points')->default(10)->after('avatar')->comment('Количество баллов (прошек)');
            $table->integer('rating')->default(10)->after('points')->comment('Тоже количество баллов, но они не отнимаются при взятии/отмене задания. То есть только накапливаются');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('points');
            $table->dropColumn('rating');
        });
    }
}

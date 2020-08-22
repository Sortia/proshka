<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUsersAddRegistrationColumns extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('surname')->nullable()->after('name');
            $table->string('nickname')->nullable()->after('surname');
            $table->string('city')->nullable()->after('nickname');
            $table->string('avatar')->nullable()->after('city');
            $table->string('phone')->nullable()->after('avatar');
            $table->unsignedBigInteger('representative_id')->nullable()->after('avatar')->comment('Представитель ученика. Ссылка на эту же таблицу');

            $table->foreign('representative_id')->references('id')->on('users');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_representative_id_foreign');

            $table->dropColumn('surname');
            $table->dropColumn('nickname');
            $table->dropColumn('city');
            $table->dropColumn('avatar');
            $table->dropColumn('phone');
            $table->dropColumn('representative_id');
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterQuestionsChangeTypeColumn extends Migration
{
    public function up()
    {
        DB::unprepared("ALTER TABLE
            `questions`
        MODIFY COLUMN
            `type` enum(
                'select',
                'text',
                'none',
                'select_many'
            )
        NOT NULL AFTER `id`;");
    }

    public function down()
    {
        DB::unprepared("ALTER TABLE
            `questions`
        MODIFY COLUMN
            `type` enum(
                'select',
                'text',
                'none',
            )
        NOT NULL AFTER `id`;");
    }
}

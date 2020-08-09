<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable = [
        'text',
        'is_right',
        'question_id',
    ];

    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }
}

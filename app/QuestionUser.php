<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionUser extends Model
{
    protected $table = 'question_user';

    protected $fillable = [
        'question_id',
        'user_id',
        'answer_id',
        'text',
        'status',
        'comment',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function answer()
    {
        return $this->belongsTo(Answer::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function studentFiles()
    {
        return $this->morphMany(File::class, 'fileable')->where('path', 'like', 'user_answers%');
    }

    public function teacherFiles()
    {
        return $this->morphMany(File::class, 'fileable')->where('path', 'like', 'teacher_comment%');
    }
}

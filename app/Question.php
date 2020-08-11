<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'id',
        'type',
        'accept_file',
        'question',
        'test_id',
    ];

    public function test()
    {
        return $this->belongsTo(Test::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function user()
    {
        return $this->hasOne(QuestionUser::class)->where('user_id', auth()->user()->id);
    }

    public function isActive()
    {
        if (is_null($this->user)) {
            return true;
        }

        if ($this->user->status === 'rework') {
            return true;
        }

        return false;
    }
}

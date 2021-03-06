<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrivateAnswer extends Model
{
    public $timestamps = false;

    protected $hidden = [
        'question_id',
    ];

    protected $fillable = [
        'answer_text',
        'is_right',
        'question_id'
    ];
}

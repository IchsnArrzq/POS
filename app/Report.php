<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'name',
        'profit',
        'input',
        'money',
        'total',
        'returns'
    ];
}

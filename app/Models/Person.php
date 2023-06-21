<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Person extends Model
{
    use HasFactory;

    public $table = 'people';

    public $fillable = [
        'title',
        'first_name',
        'initial',
        'last_name',
    ];
}

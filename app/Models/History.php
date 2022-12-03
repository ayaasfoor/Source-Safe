<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class History extends Model
{
    public $table = 'histories';
    protected $fillable = ['user_id', 'file_id', 'type_user', 'type_opartion', 'date'];
}
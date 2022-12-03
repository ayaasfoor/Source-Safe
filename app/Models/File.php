<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'slug', 'group-id', 'path'];

    /**
     *  The reation many to many  with users
     *
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'histories')->using(History::class);
    }

    /**
     * One to many with group
     *
     */

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    /**
     * get key to route name
     *
     */

    public function getRouteKeyName()
    {
        return 'slug';
    }
    /**
     * asset path storage file
     */
    public function getPathAttribute($value)
    {
        return asset("storage/{$value}");
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Berita extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id', 'deleted_at', 'updated_at', 'created_at'];

    /**
     * Relation one to many with comment model
     *
     * @return void
     */
    public function Comments()
    {
        return $this->hasMany(Comment::class, 'berita_id');
    }

    /**
     * Relation with user model
     *
     * @return void
     */
    public function User()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

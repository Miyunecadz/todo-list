<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function scopeSubTodos()
    {
        return $this->whereNot('parent_id', null);
    }

    public function parentTodo()
    {
        return $this->belongsTo(Todo::class, 'parent_id', 'id');
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function subTodos()
    {
        return $this->hasMany(Todo::class, 'parent_id', 'id');
    }
}

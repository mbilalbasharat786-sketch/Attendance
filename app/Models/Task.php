<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['user_id', 'title', 'description', 'status', 'user_response', 'admin_feedback'];

    public function user() {
        return $this->belongsTo(User::class);
    }
}

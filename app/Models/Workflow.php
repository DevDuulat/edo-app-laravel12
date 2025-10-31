<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workflow extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'note', 'due_date', 'workflow_status', 'user_id'
    ];

    public function users() {
        return $this->hasMany(WorkflowUser::class);
    }

    public function documents() {
        return $this->belongsToMany(Document::class, 'workflow_document');
    }

    public function initiator() {
        return $this->belongsTo(User::class, 'user_id');
    }
}

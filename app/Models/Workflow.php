<?php

namespace App\Models;

use App\Traits\HasStatusLifecycle;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workflow extends Model
{
    use HasFactory, HasStatusLifecycle;

    protected $fillable = [
        'title', 'slug', 'note', 'due_date', 'workflow_status', 'status', 'user_id'
    ];

    public function users() {
        return $this->hasMany(WorkflowUser::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function documents() {
        return $this->belongsToMany(Document::class, 'workflow_document')
            ->using(WorkflowDocument::class)
            ->withTimestamps();
    }

    public function initiator() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function comments()
    {
        return $this->hasMany(WorkflowComment::class);
    }
}

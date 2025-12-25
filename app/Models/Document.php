<?php

namespace App\Models;

use App\Enums\DocumentType;
use App\Enums\WorkflowStatus;
use App\Traits\HasStatusLifecycle;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory, HasStatusLifecycle;

    protected $fillable = [
        'title',
        'slug',
        'document_type',
        'comment',
        'content',
        'due_date',
        'template_id',
        'folder_id',
        'category_id',
        'approved_at',
        'status',
        'workflow_status',
        'user_id',
    ];
    protected $casts = [
        'status' => \App\Enums\Status::class,
        'document_type' => DocumentType::class,
        'workflow_status' => WorkflowStatus::class,
    ];

    public function workflows()
    {
        return $this->belongsToMany(Workflow::class, 'workflow_document')
            ->using(WorkflowDocument::class)
            ->withTimestamps()
            ->orderBy('workflow_document.created_at', 'desc');
    }

    public function files()
    {
        return $this->hasMany(DocumentFile::class);
    }

    public function template()
    {
        return $this->belongsTo(\App\Models\DocumentTemplate::class, 'template_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}

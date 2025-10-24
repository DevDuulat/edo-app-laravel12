<?php

namespace App\Models;

use App\Enums\DocumentType;
use App\Enums\WorkflowStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'document_type',
        'comment',
        'due_date',
        'folder_id',
        'approved_at',
        'workflow_status',
        'user_id',
    ];
    protected $casts = [
        'document_type' => DocumentType::class,
        'workflow_status' => WorkflowStatus::class,
    ];
}

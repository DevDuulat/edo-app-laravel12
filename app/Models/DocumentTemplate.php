<?php

namespace App\Models;

use App\Traits\HasStatusLifecycle;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentTemplate extends Model
{
    use HasFactory ,HasStatusLifecycle;

    protected $fillable = ['name', 'slug', 'description', 'active', 'status', 'content'];

    public function documents()
    {
        return $this->belongsToMany(Document::class, 'document_template_document');
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tonysm\RichTextLaravel\Models\Traits\HasRichText;

class DocumentTemplate extends Model
{
    use HasFactory;
    use HasRichText;

    protected $fillable = ['name', 'slug', 'description', 'active', 'content'];

    public function documents()
    {
        return $this->belongsToMany(Document::class, 'document_template_document');
    }

    protected $richTextAttributes = [
        'content',
    ];
}

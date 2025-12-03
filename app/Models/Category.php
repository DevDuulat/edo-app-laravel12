<?php

namespace App\Models;

use App\Traits\HasStatusLifecycle;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory, HasStatusLifecycle;

    protected $fillable = [
        'name',
        'status',
    ];

    public function documents()
    {
        return $this->hasMany(Document::class);
    }
}

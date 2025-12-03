<?php

namespace App\Models;

use App\Enums\Status;
use App\Traits\HasStatusLifecycle;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    use HasFactory, HasStatusLifecycle;

    protected $fillable = [
        'name',
        'slug',
        'path',
        'order_index',
        'status',
        'parent_id',
        'retention_period',
        'created_by',
        'updated_by',
        'user_id',
    ];


    protected $casts = [
        'status' => Status::class,
    ];


    public function parent()
    {
        return $this->belongsTo(Folder::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Folder::class, 'parent_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function ancestors()
    {
        return $this->parent()->with('ancestors');
    }




}

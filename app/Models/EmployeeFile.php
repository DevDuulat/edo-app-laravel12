<?php

namespace App\Models;

use App\Enums\EmployeeFileType;
use Illuminate\Database\Eloquent\Model;

class EmployeeFile extends Model
{
    protected $fillable = [
        'employee_id',
        'file_name',
        'file_url',
        'type',
        'uploaded_at',
    ];

    protected $casts = [
        'type' => EmployeeFileType::class,
    ];

    public $timestamps = false;

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'position',
        'salary',
        'hire_date',
        'department_id',
        'passport_number',
        'inn',
        'avatar_url',
    ];
    protected $casts = [
        'hire_date' => 'date', // <-- добавляем это
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }



    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}

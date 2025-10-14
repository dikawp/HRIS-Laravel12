<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'employee_id',
        'date',
        'check_in',
        'check_out',
        'status',
        'notes',
    ];

    /**
     * Mendapatkan data employee yang memiliki absensi ini.
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}

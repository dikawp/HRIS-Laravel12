<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
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

    protected function workHours(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->check_in && $this->check_out) {
                    $checkIn = Carbon::parse($this->check_in);
                    $checkOut = Carbon::parse($this->check_out);

                    $totalMinutes = $checkIn->diffInMinutes($checkOut);

                    $hours = floor($totalMinutes / 60);
                    $minutes = $totalMinutes % 60;

                    return sprintf('%d hr %02d min', $hours, $minutes);
                }

                return '-';
            }
        );
    }
}

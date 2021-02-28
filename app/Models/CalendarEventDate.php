<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalendarEventDate extends Model
{
    use HasFactory;

    public $fillable = ['date'];

    public $with = ['event'];

    public function event()
    {
        return $this->belongsTo(CalendarEvent::class, "event_id", "id");
    }



}

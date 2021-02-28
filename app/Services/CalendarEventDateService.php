<?php


namespace App\Services;


use App\Contracts\Services\CalendarEventDateServiceInterface;
use App\Models\CalendarEventDate;
use Illuminate\Database\Eloquent\Collection;

class CalendarEventDateService implements CalendarEventDateServiceInterface
{

    public function all(): Collection
    {
        return CalendarEventDate::with('event')->get();
    }

    public function delete(CalendarEventDate $date): CalendarEventDate
    {
        $date->delete();

        return $date;
    }
}

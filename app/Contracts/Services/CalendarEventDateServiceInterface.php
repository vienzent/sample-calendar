<?php


namespace App\Contracts\Services;


use App\Models\CalendarEventDate;
use Illuminate\Database\Eloquent\Collection;

interface CalendarEventDateServiceInterface
{
    public function all(): Collection;
    public function delete(CalendarEventDate $date): CalendarEventDate;
}

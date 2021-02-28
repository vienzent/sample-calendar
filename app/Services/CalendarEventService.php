<?php


namespace App\Services;


use App\Contracts\Services\CalendarEventServiceInterface;
use App\Models\CalendarEvent;
use App\Models\CalendarEventDate;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;


class CalendarEventService implements CalendarEventServiceInterface
{

    public function add($event): CalendarEvent
    {
        return DB::transaction(function () use ($event) {
            $event = CalendarEvent::create($event);

            $periods = CarbonPeriod::create($event->start_date, $event->end_date);

            $dates = [];

            foreach ($periods as $period) {
                if (in_array($period->dayOfWeek, $event->days)) {
                    $dates[] = new CalendarEventDate(['date' => $period->format("Y-m-d")]);
                }
            }

            if (count($dates) === 0) {
                throw new \Exception("Dates are required."); // TODO: create exception class
            }

            $event->dates()->saveMany($dates);

            return $event;
        });

    }

    public function delete(CalendarEvent $event): CalendarEvent
    {
        return DB::transaction(function () use ($event) {
            $event->dates()->delete();
            $event->delete();

            return $event;
        });
    }
}

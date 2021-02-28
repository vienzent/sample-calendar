<?php


namespace App\Contracts\Services;


use App\Models\CalendarEvent;

interface CalendarEventServiceInterface
{
    public function add($event) : CalendarEvent;
    public function delete(CalendarEvent $event) : CalendarEvent;
}

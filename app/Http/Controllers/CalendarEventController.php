<?php

namespace App\Http\Controllers;

use App\Contracts\Services\CalendarEventServiceInterface;
use App\Http\Requests\CalendarEvents\AddEventRequest;
use App\Http\Resources\CalendarEventResource;
use App\Models\CalendarEvent;

class CalendarEventController extends Controller
{
    protected $service;

    /**
     * CalendarEventController constructor.
     * @param CalendarEventServiceInterface $service
     */
    public function __construct(CalendarEventServiceInterface $service)
    {
        $this->service = $service;
    }

    public function store(AddEventRequest $request)
    {
        return new CalendarEventResource(
            $this->service->add(
                $request->all()
            )
        );
    }

    public function destroy(CalendarEvent $event)
    {
        return new CalendarEventResource(
            $this->service->delete($event)
        );
    }
}

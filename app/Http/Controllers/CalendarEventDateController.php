<?php

namespace App\Http\Controllers;

use App\Contracts\Services\CalendarEventDateServiceInterface;
use App\Http\Resources\CalendarEventDateResource;
use App\Models\CalendarEventDate;
use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class CalendarEventDateController extends Controller
{
    protected $service;

    public function __construct(CalendarEventDateServiceInterface $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $events = QueryBuilder::for(CalendarEventDate::class)
            ->allowedFilters([
                AllowedFilter::callback('year_month', function (Builder $query, $value) {

                    try {
                        $date = Carbon::createFromFormat('Y-m', $value);
                    } catch (InvalidFormatException $ex) {
                        $query->whereRaw("1 = 0");
                        return;
                    }

                    $query->whereBetween("date", [
                        $date->startOfMonth()->format('Y-m-d'),
                        $date->endOfMonth()->format('Y-m-d')
                    ]);
                })
            ])
            ->defaultSort('created_at')
            ->with('event')
            ->get();

        return CalendarEventDateResource::collection($events);
    }

    public function destroy(CalendarEventDate $date)
    {
        return new CalendarEventDateResource(
            $this->service->delete($date)
        );
    }
}

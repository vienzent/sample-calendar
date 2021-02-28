<?php

use App\Http\Controllers\CalendarEventController;
use App\Http\Controllers\CalendarEventDateController;
use Illuminate\Support\Facades\Route;


Route::prefix('calendar/events')->group(function () {
    Route::post('/', [CalendarEventController::class, 'store']);
    Route::delete("{event}", [CalendarEventController::class, 'destroy']);
});

Route::prefix('calendar/event/dates')->group(function () {
    Route::get('/', [CalendarEventDateController::class, 'index']);
    Route::delete('{date}', [CalendarEventDateController::class, 'destroy']);
});


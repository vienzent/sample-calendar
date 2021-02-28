<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCalendarEventDatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calendar_event_dates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("event_id");
            $table->date("date");
            $table->timestamps();

            $table->foreign('event_id')->references('id')->on('calendar_events');
            $table->index("date");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('calendar_event_dates');
    }
}

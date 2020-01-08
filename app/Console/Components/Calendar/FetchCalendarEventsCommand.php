<?php

namespace App\Console\Components\Calendar;

use DateTime;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Spatie\GoogleCalendar\Event;
use App\Events\Calendar\EventsFetched;

class FetchCalendarEventsCommand extends Command
{
    protected $signature = 'dashboard:fetch-calendar-events';

    protected $description = 'Fetch events from a Google Calendar';

    public function handle()
    {
        $this->info('Fetching calendar events...');

        $events = collect(Event::get(today(), today()->addDays(2)))
            ->map(function (Event $event) {
                $sortDate = $event->getSortDate();

                return [
                    'name' => $event->name,
                    'date' => Carbon::createFromFormat('Y-m-d H:i:s', $sortDate)->format(DateTime::ATOM),
                    'enddate' => Carbon::createFromDate($event->end->getDateTime())->format(DateTime::ATOM),
                    'allDay' => $event->isAllDayEvent(),
                ];
            })
            ->toArray();

        event(new EventsFetched($events));

        $this->info('All done!');
    }
}

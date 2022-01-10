<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Event;
use App\Repositories\EventRepository;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Nette\Utils\DateTime;

class GetNewEvents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:events';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get new events';

    /**
     * Key for NASA API
     *
     * @var string
     */
    private const API_KEY = "szayfCQ20Jb8XdSzyjU5sjlrGK6AJ116LejoJe7D";

    /**
     * URL to NASA API to grab information about events
     *
     * @var string
     */
    private const URL = "https://eonet.gsfc.nasa.gov/api/v2.1/events";

    /**
     * @var EventRepository
     */
    private $eventRepository;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(EventRepository $eventRepository)
    {
        parent::__construct();
        $this->eventRepository = $eventRepository;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $res = Http::withHeaders(
            [
                "Accept" => 'text/html,application/json,application/xml;',
                "Accept-Encoding" => 'gzip, deflate',
                "Accept-Language" => 'en-US,en;',
                "Connection" => 'keep-alive'
            ]
        )->get(self::URL, [
            "api_key" => self::API_KEY
        ]);

        $events = $res->json()['events'];
        $this->eventRepository->store($events);

        Log::info("Events are successfully got");
    }
}

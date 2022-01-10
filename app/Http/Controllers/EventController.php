<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Event;
use Illuminate\Support\Facades\Artisan;

class EventController extends Controller
{
    public function events()
    {
        Artisan::call("get:events");
        $events = Event::all(['id', 'title', 'date', 'coordinates', 'category_id']);

        return $events->toJson();
    }

    public function categories(){
        $categories = Category::all();
        return $categories->toJson();
    }

    public function show(){
        return view('example');
    }
}

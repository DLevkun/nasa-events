<?php

namespace App\Repositories;

use App\Models\Category;
use App\Models\Event;
use Nette\Utils\DateTime;

class EventRepository
{
    public function store($events){
        foreach($events as $event){
            $eventModel = new Event();
            $id = $event['id'];
            if(!Event::find($id)) {
                $eventModel->id = $event['id'];
                $eventModel->title = $event['title'];
                $eventModel->description = $event['description'];
                $category_id = $event['categories'][0]['id'];
                $eventModel->category_id = $category_id;
                $categoryModel = Category::firstOrCreate(["id" => $category_id]);
                $categoryModel->title = $event['categories'][0]['title'];
                $categoryModel->save();

                $geometries = $event['geometries'][0];
                $date = new DateTime($geometries["date"]);
                $eventModel->date = $date;
                //$eventModel->coordinates = serialize($geometries["coordinates"]);
                $coords = $geometries["coordinates"];
                $ref = "https://maps.google.com/maps?q=$coords[1],$coords[0]&ll=$coords[1],$coords[0]&z=12";
                $eventModel->coordinates = $ref;

                $eventModel->save();
            }
        }
    }
}

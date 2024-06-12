<?php 

namespace App\Controllers;

use App\Models\EventModel;

class Event extends Controller {
    protected object $event;

    public function __construct($param) {
        $this->event = new EventModel();
        parent::__construct($param);
    }

    protected function setCorsHeaders() {
        header('Access-Control-Allow-Origin: *');
        header('Content-type: application/json; charset=utf-8');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
        header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
    }

    public function optionsEvent() {  
        $this->setCorsHeaders();
        header('HTTP/1.0 200 OK');
    }

    public function postEvent() {
        $this->setCorsHeaders();

        $title = $this->body['title'] ?? null;
        $name = $this->body['name'] ?? null;
        $adress = $this->body['adress'] ?? null;
        $description = $this->body['description'] ?? null;
        $numero = $this->body['numero'] ?? null;
        $date = $this->body['date'] ?? null;
        $time = $this->body['time'] ?? null;

        if (!$title || !$name || !$adress || !$description || !$numero || !$date || !$time) {
            return json_encode([
                'status' => 'error',
                'message' => 'All fields are required'
            ]);
        }

        if ($this->event->exists($title)) {
            return json_encode([
                'status' => 'error',
                'message' => 'Event already exists'
            ]);
        }

        $data = [
            'title' => $title,
            'name' => $name,
            'adress' => $adress,
            'description' => $description,
            'numero' => $numero,
            'date' => $date,
            'time' => $time
        ];

        $this->event->add($data);

        return json_encode([
            'status' => 'success',
            'message' => 'Event added successfully'
        ]);
    }

    public function putEvent($id) {
        $this->setCorsHeaders();

        $title = $this->body['title'] ?? null;
        $name = $this->body['name'] ?? null;
        $adress = $this->body['adress'] ?? null;
        $description = $this->body['description'] ?? null;
        $numero = $this->body['numero'] ?? null;
        $date = $this->body['date'] ?? null;
        $time = $this->body['time'] ?? null;

        if (!$title || !$name || !$adress || !$description || !$numero || !$date || !$time) {
            return json_encode([
                'status' => 'error',
                'message' => 'All fields are required'
            ]);
        }

        $data = [
            'id' => $id,
            'title' => $title,
            'name' => $name,
            'adress' => $adress,
            'description' => $description,
            'numero' => $numero,
            'date' => $date,
            'time' => $time
        ];

        $this->event->update($data);

        return json_encode([
            'status' => 'success',
            'message' => 'Event updated successfully'
        ]);
    }

    public function deleteEvent($id) {
        $this->setCorsHeaders();

        $this->event->delete($id);

        return json_encode([
            'status' => 'success',
            'message' => 'Event deleted successfully'
        ]);
    }
}

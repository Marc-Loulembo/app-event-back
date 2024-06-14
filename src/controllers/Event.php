<?php 

namespace App\Controllers;

use App\Models\EventModel;
use Exception;

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

        try {
            $data = json_decode(file_get_contents('php://input'), true);

            if (!$data) {
                throw new Exception('Invalid JSON data');
            }

            $data = [
                'title' => $data['title'] ?? NULL,
                'name' => $data['name'] ?? NULL,
                'adress' => $data['adress'] ?? NULL,
                'description' => $data['description'] ?? NULL,
                'numero' => $data['numero'] ?? NULL,
                'date' => $data['date'] ?? NULL,
                'time' => $data['time'] ?? NULL
            ];

            $this->event->add($data);

        } catch (Exception $e) {
            return 'error';
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function putEvent($id) {
        $this->setCorsHeaders();

        try {
            $data = json_decode(file_get_contents('php://input'), true);

            if (!$data) {
                throw new Exception('Invalid JSON data');
            }

            $data = [
                'id' => $id,
                'title' => $data['title'] ?? '',
                'name' => $data['name'] ?? '',
                'adress' => $data['adress'] ?? '',
                'description' => $data['description'] ?? '',
                'numero' => $data['numero'] ?? '',
                'date' => $data['date'] ?? '',
                'time' => $data['time'] ?? ''
            ];

            if (empty($data['title']) || empty($data['name']) || empty($data['adress']) || empty($data['description']) || empty($data['numero']) || empty($data['date']) || empty($data['time'])) {
                throw new Exception('All fields are required');
            }

            $this->event->update($data);

            echo json_encode(['status' => 'success', 'message' => 'Event updated successfully']);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function deleteEvent($id) {
        $this->setCorsHeaders();

        try {
            $this->event->delete($id);

            echo json_encode(['status' => 'success', 'message' => 'Event deleted successfully']);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}

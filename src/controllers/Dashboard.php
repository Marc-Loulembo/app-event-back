<?php

namespace App\Controllers;

use App\Models\EventModel;

class Dashboard extends Controller {
  protected object $eventModel;

  public function __construct($param) {
    $this->eventModel = new EventModel();
    parent::__construct($param);
  }

  protected function setCorsHeaders() {
    header('Access-Control-Allow-Origin: *');
    header('Content-type: application/json; charset=utf-8');
    header('Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE');
    header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
  }

  public function getDashboard() {
    $this->setCorsHeaders();
    return $this->eventModel->getAll();
  }

  public function postEvent() {
    $this->setCorsHeaders();

    $this->eventModel->add($this->body);

    echo json_encode([
      'status' => 'success',
      'message' => 'Event added successfully'
    ]);
  }
}

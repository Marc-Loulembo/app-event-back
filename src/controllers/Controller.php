<?php

namespace App\Controllers;

class Controller {
  protected array $params;
  protected string $reqMethod;
  protected array $body;
  protected string $className;

  public function __construct($params) {
    $this->className = $this->getCallerClassName();
    $this->params = $params;
    $this->reqMethod = strtolower($_SERVER['REQUEST_METHOD']);
    $this->body = (array) json_decode(file_get_contents('php://input'));

    $this->header();
    $this->ifMethodExist();

    $this->optionsEvent();
  }

  protected function getCallerClassName() {
    $backtrace = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 2);

    if (isset($backtrace[1]['object'])) {
      $fullClassName = get_class($backtrace[1]['object']);
      $className = basename(str_replace('\\', '/', $fullClassName));

      return $className;
    }

    return 'Unknown';
  }

  protected function header() {
    header('Access-Control-Allow-Origin: http://127.0.0.1:9090');
    header('Content-type: application/json; charset=utf-8');
    header("Access-Control-Allow-Headers", "Content-Type, Authorization, X-Requested-With");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, PATCH, OPTIONS");
  }

  protected function setCorsHeaders() {
    header('Access-Control-Allow-Origin: *');     
    header('Content-type: application/json; charset=utf-8');    
    header('Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE');     
    header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');   
  }

  public function optionsEvent() {  
    $this->setCorsHeaders();
    header('HTTP/1.0 200 OK'); 
  }

  protected function ifMethodExist() {
    $method = $this->reqMethod.''.$this->className;

    if (method_exists($this, $method)) {
      echo json_encode($this->$method());

      return;
    }

    header('HTTP/1.0 404 Not Found');
    echo json_encode([
      'code' => '404',
      'message' => 'Not Found'
    ]);

    return;
  }
}
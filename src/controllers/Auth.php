<?php 
namespace App\Controllers;

use App\Models\UserModel;


class Auth extends Controller {
  protected object $user;

  public function __construct($param) {
    $this->user = new UserModel();
    parent::__construct($param);

    $this->optionsEvent();
  }

  /*public function postAuth() {
    echo json_encode($this->body);
    $this->body['password'] = password_hash($this->body['password'], PASSWORD_BCRYPT);
    $this->user->add($this->body);
    return $this->user->getLast();
  }*/

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
  
  public function postAuth() {
   $user = $this->user->getByEmail($this->body['email']);

    if ($user && password_verify($this->body['password'], $user['password'])) {
      return [
        'status' => 'success',
        'message' => 'Login successful'
      ];
    }

    return [
      'status' => 'error',
      'message' => 'Invalid email or password'
    ];
  }
}

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
    $this->setCorsHeaders();
    
    error_log("Request body: " . json_encode($this->body));
    
    $email = $this->body['email'];
    $password = $this->body['password'];

    error_log("Email: $email, Password: $password");

    $user = $this->user->getByEmail($email);

    if ($user) {
        error_log("User found: " . json_encode($user));
    } else {
        error_log("User not found");
    }

    if ($user && password_verify($password, $user['password'])) { //pour récupérer un mot de passe hashé : password_verify($password, $user['password'])
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

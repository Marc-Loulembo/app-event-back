<?php 

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends Controller {
  protected object $user;

  public function __construct($param) {
    $this->user = new UserModel();
    parent::__construct($param);

    $this->optionsEvent();
    session_start();
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

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user;
        return [
            'status' => 'success',
            'message' => 'Login successful',
            'user' => $user
        ];
        return ;
    }

    return [
        'status' => 'error',
        'message' => 'Invalid email or password'
    ];
  }

  public function getLogout() {
    session_unset();
    session_destroy();
    return [
        'status' => 'success',
        'message' => 'Logout successful'
    ];
  }

  public function getStatus() {
    if (isset($_SESSION['user'])) {
        return [
            'status' => 'success',
            'message' => 'User is logged in',
            'user' => $_SESSION['user']
        ];
    }
    return [
        'status' => 'error',
        'message' => 'User is not logged in'
    ];
  }
}

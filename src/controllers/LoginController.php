<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\UserModel;

class LoginController extends Controller {
  
  protected $userModel;

  public function __construct($params) {
    $this->userModel = new UserModel();
    parent::__construct($params);
  }

  public function postLogin() {
    $email = isset($this->body['email']) ? $this->body['email'] : null;
    $password = isset($this->body['password']) ? $this->body['password'] : null;

    if ($email && $password) {
      $user = $this->userModel->getByEmail($email);
      
      if ($user && password_verify($password, $user['password'])) {
        return [
          'status' => 'success',
          'message' => 'Login successful',
          'user' => $user
        ];
      } else {
        
        return [
          'status' => 'error',
          'message' => 'Invalid email or password'
        ];
      }
    } else {
      return [
        'status' => 'error',
        'message' => 'Email and password are required'
      ];
    }
  }
}

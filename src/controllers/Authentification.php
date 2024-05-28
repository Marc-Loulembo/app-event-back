<?php 
namespace App\Controllers;

use App\Models\UserModel;

class Auth extends Controller {
  protected object $user;

  public function __construct($param) {
    $this->user = new UserModel();
    parent::__construct($param);
  }

  public function postRegister() {
    echo json_encode($this->body);
    $this->body['password'] = password_hash($this->body['password'], PASSWORD_BCRYPT);
    $this->user->add($this->body);
    return $this->user->getLast();
  }

  public function postLogin() {
    $user = $this->user->getByEmail($this->body['email']);
    if ($user && password_verify($this->body['password'], $user['password'])) {
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
  }
}

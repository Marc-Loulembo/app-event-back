<?php 

namespace App\Controllers;

use App\Models\UserModel;

class Register extends Controller {
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

    public function postRegister() {
        $this->setCorsHeaders();

        $first_name = $this->body['firstname'];
        $name = $this->body['name'];
        $email = $this->body['email'];
        $numero = $this->body['numero'];
        $password = $this->body['password'];

        // je check si l'utilisateur existe déjà 
        if ($this->user->getByEmail($email)) {
            return [
                'status' => 'error',
                'message' => 'Email already in use'
            ];
        }

        // hashage du mot de passe
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        $data = [
            'firstname' => $first_name,
            'name' => $name,
            'email' => $email,
            'numero' => $numero,
            'password' => $hashed_password
        ];

        // j'envoie l'utilisateur dans la base de donnée
        $this->user->add($data);

        return [
            'status' => 'success',
            'message' => 'Registration successful'
        ];
    }
}

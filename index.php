<?php

require 'vendor/autoload.php';

use App\Router;
use App\Controllers\User;
use App\Controllers\Authentification;
// use App\Controllers\LoginController;

new Router([
  'user/:id' => User::class,
  'register' => Authentification::class, 
  'login' => Authentification::class,
]);

<?php

require 'vendor/autoload.php';

use App\Router;
use App\Controllers\User;
use App\Controllers\Auth;
use App\Controllers\Register;

new Router([
  'user/:id' => User::class,
  'register' => Register::class,
  'auth' => Auth::class
]);

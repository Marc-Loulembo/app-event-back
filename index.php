<?php

require 'vendor/autoload.php';

use App\Router;
use App\Controllers\User;
use App\Controllers\Auth;
use App\Controllers\Register;
use App\Controllers\Dashboard;

new Router([
  'user/:id' => User::class,
  'register' => Register::class,
  'auth' => Auth::class,
  'dashboard/:events' => Dashboard::class
]);

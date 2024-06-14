<?php

require 'vendor/autoload.php';

use App\Router;
use App\Controllers\User;
use App\Controllers\Auth;
use App\Controllers\Register;
use App\Controllers\Dashboard;
use App\Controllers\Event;

new Router([
  'user/:id' => User::class,
  'register' => Register::class,
  'auth' => Auth::class,
  // 'auth/:logout' => Auth::class,
  'dashboard/:events' => Dashboard::class,
  'event' => Event::class,

]);

<?php

use Illuminate\Support\Facades\Route;

// The panel is the whole application: the landing page and the "Dashboard" link both lead there.
Route::redirect('/', '/admin');
Route::redirect('/dashboard', '/admin');

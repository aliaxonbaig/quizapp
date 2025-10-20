<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    // If user is authenticated, redirect to their appropriate panel
    if (auth()->check()) {
        $user = auth()->user();
        
        // Teachers go to admin panel by default
        if ($user->hasRole('teacher')) {
            return redirect('/admin');
        }
        
        // Students go to member panel
        if ($user->hasRole('student')) {
            return redirect('/member');
        }
    }
    
    // Guest users see the welcome page
    return view('welcome');
});

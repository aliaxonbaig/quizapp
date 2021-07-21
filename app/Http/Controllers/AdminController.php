<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function adminhome()
    {
        $latestUsers = User::latest()->take(5)->get();
        return view('admins.adminhome', compact('latestUsers'));
    }
}

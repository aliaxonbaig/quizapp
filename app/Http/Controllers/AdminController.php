<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Section;
use App\Models\Question;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function adminhome()
    {
        $sectionCount = Section::count();
        $questionCount = Question::count();
        $userCount = User::count();
        $latestUsers = User::latest()->take(5)->get();
        return view('admins.adminhome', compact('latestUsers', 'sectionCount', 'questionCount', 'userCount'));
    }
}

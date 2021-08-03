<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Section;
use App\Models\Question;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class AppUserController extends Controller
{
    public function index()
    {
        $activeUsers = User::count();
        $questionsCount = Question::where('is_active', '1')->count();
        $sections = Section::withCount('questions')
            ->where('is_active', '1')
            ->orderBy('name')
            ->get();

        return view('appusers.index', compact('sections', 'activeUsers', 'questionsCount'));
    }

    public function startQuiz(Request $request)
    {
        $request->validate([
            'section' => 'required',
            'quizSize' => 'required|numeric'
        ]);
        $sectionId = $request->section;
        $quizSize = $request->quizSize;

        return view('appusers.quiz', compact('sectionId', 'quizSize'));
    }
}

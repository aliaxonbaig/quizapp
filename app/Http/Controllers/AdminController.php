<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Section;
use App\Models\Question;
use App\Models\QuizHeader;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function adminhome()
    {
        $sectionCount = Section::count();
        $questionCount = Question::count();
        $quizCount = QuizHeader::count();
        $userCount = User::count();
        $latestUsers = User::latest()->take(5)->get();
        return view('admins.adminhome', compact('latestUsers', 'sectionCount', 'questionCount', 'userCount', 'quizCount'));
    }

    public function globalQuizzes()
    {
        $activeUsers = User::count();

        $questionsCount = Question::where('is_active', '1')->count();

        $sections = Section::withCount('questions')
            ->where('is_active', '1')
            ->orderBy('name')
            ->get();

        $quizesTaken = QuizHeader::count();

        $userQuizzes = QuizHeader::orderBy('id', 'desc')
            ->paginate(10);

        $quizAverage = QuizHeader::avg('score');

        return view(
            'admins.globalQuizzes',
            compact(
                'sections',
                'activeUsers',
                'questionsCount',
                'quizesTaken',
                'userQuizzes',
                'quizAverage'
            )
        );
    }
}

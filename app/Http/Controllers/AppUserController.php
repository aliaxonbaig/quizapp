<?php

namespace App\Http\Controllers;

use App\Models\Section;
use App\Models\Question;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class AppUserController extends Controller
{
    public function index()
    {
        $sections = Section::where('is_active', '1')
            ->orderBy('name')
            ->get();

        return view('appusers.index', compact('sections'));
    }

    public function startQuiz(Request $request)
    {
        $section_id = $request->section;
        $size = $request->number;

        return view('appusers.quiz', compact('section_id', 'size'));
    }
}

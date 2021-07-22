<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;

class QuestionsController extends Controller
{
    public function createQuestion(Section $section)
    {
        $section = $section;
        return view('admins.create_question', compact('section'));
    }

    public function storeQuestion(Section $section, Request $request)
    {
        $data = $request->validate([
            'question' => 'required',
            'explanation' => 'required',
            'is_active' => 'required',

        ]);
    }
}

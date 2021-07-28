<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Section;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionsController extends Controller
{
    public function createQuestion(Section $section)
    {
        $section = $section;
        return view('admins.create_question', compact('section'));
    }

    public function detailQuestion(Question $question)
    {
        $answers = $question->answers()->paginate(10);
        return view('admins.detail_question', compact('question', 'answers'));
    }

    public function storeQuestion(Section $section, Request $request)
    {
        $section = $section;
        $data = $request->validate([
            'question' => 'required',
            'explanation' => 'required',
            'is_active' => 'required',
            'answers.*.answer' => 'required',
            'answers.*.is_checked' => 'present'
        ]);


        $question = Question::create([
            'question' => $request->question,
            'explanation' => $request->explanation,
            'is_active' => $request->is_active,
            'user_id' => Auth::id(),
            'section_id' => $section->id,
        ]);

        $status = $question->answers()->createMany($data['answers'])->push();
        return redirect()->route('detailSection', $section->id)->withSuccess('Questin created successfully');;
    }

    function deleteQuestion($id)
    {
        //$sections = Section::paginate(10);
        $question = Question::findOrFail($id);
        $question->delete();
        return redirect()->back()->withSuccess('Question with id: ' . $question->id . ' deleted successfully');
    }
}

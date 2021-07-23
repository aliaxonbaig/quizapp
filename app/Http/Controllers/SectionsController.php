<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;

class SectionsController extends Controller
{
    public function createSection()
    {
        return view('admins.create_section');
    }

    public function storeSection(Request $request)
    {
        $data = $request->validate([
            'section.*' => 'required',
        ]);
        auth()->user()->sections()->createMany($data);
        $request->session()->flash('message', 'Section saved successfully!');
        return redirect()->back();
    }

    public function listSection()
    {
        $sections = Section::paginate(10);
        return view('admins.list_sections', compact('sections'));
    }

    public function editSection(Section $section)
    {
        return view('admins.edit_section', compact('section'));
    }

    public function updateSection(Section $section, Request $request)
    {
        $data = $request->validate([
            'name' => 'required|min:5|max:255',
            'description' => 'required|min:5|max:255',
            'is_active' => 'required',
            'details' =>    'required|min:10|max:1024',
        ]);
        $record = Section::findOrFail($section->id);
        $input = $request->all();
        $record->fill($input)->save();
        $request->session()->flash('message', 'Section saved successfully!');
        return $this->listSection();
    }

    public function detailSection(Section $section)
    {
        $questions = $section->questions()->paginate(10);
        return view('admins.detail_sections', compact('questions', 'section'));
    }
}

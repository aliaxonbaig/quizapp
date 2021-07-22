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

        $sections = Section::paginate(5);
        return view('admins.list_sections', compact('sections'));
    }
}

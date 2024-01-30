<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TeacherController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt', ['except' => ['publicMethod']]);
    }

    public function index()
    {
        $teachers = Teacher::all();
        return response()->json(['teachers' => $teachers]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
        ]);

        $teacher = Teacher::create([
            'name' => $request->input('name'),
            'subject' => $request->input('subject'),
        ]);

        return response()->json(['message' => 'Teacher created successfully', 'teacher' => $teacher]);
    }

    public function show(Teacher $teacher)
    {
        return response()->json(['teacher' => $teacher]);
    }

    public function update(Request $request, Teacher $teacher)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
        ]);

        $teacher->update([
            'name' => $request->input('name'),
            'subject' => $request->input('subject'),
        ]);

        return response()->json(['message' => 'Teacher updated successfully', 'teacher' => $teacher]);
    }

    public function destroy(Teacher $teacher)
    {
        $teacher->delete();
        return response()->json(['message' => 'Teacher deleted successfully']);
    }
}

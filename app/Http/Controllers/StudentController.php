<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt', ['except' => ['publicMethod']]);
    }

    public function index()
    {
        $students = Student::all();
        return response()->json(['students' => $students]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'age' => 'required|integer',
            'email' => 'required|email|unique:students',
            'password' => 'required|string|min:8',
        ]);


        $student = Student::create([
            'name' => $request->input('name'),
            'age' => $request->input('age'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);


        return response()->json(['message' => 'Student created successfully', 'student' => $student]);
    }

    public function show(Student $student)
    {
        return response()->json(['student' => $student]);
    }

    public function update(Request $request, Student $student)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'age' => 'required|integer',
        ]);

        $student->update([
            'name' => $request->input('name'),
            'age' => $request->input('age'),
        ]);

        return response()->json(['message' => 'Student updated successfully', 'student' => $student]);
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return response()->json(['message' => 'Student deleted successfully']);
    }
}

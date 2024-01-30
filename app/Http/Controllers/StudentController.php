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
            'first_name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'student_num' => 'required|string|max:255|unique:students',
            'birth_date' => 'required|date',
            'address' => 'required|string|max:255',
            'parent_phone_number' => 'required|string|max:20',
            'second_phone_number' => 'nullable|string|max:20',
            'gender' => 'required|string|in:Male,Female,Other',
            'classroom_id' => 'required|exists:classrooms,id',
            'enrollment_date' => 'required|date',
        ]);

        $student = Student::create([
            'first_name' => $request->input('first_name'),
            'surname' => $request->input('surname'),
            'student_num' => $request->input('student_num'),
            'birth_date' => $request->input('birth_date'),
            'address' => $request->input('address'),
            'parent_phone_number' => $request->input('parent_phone_number'),
            'second_phone_number' => $request->input('second_phone_number'),
            'gender' => $request->input('gender'),
            'classroom_id' => $request->input('classroom_id'),
            'enrollment_date' => $request->input('enrollment_date'),
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
            'first_name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'student_num' => [
                'required',
                'string',
                'max:255',
                Rule::unique('students')->ignore($student->id),
            ],
            'birth_date' => 'required|date',
            'address' => 'required|string|max:255',
            'parent_phone_number' => 'required|string|max:20',
            'second_phone_number' => 'nullable|string|max:20',
            'gender' => 'required|string|in:Male,Female,Other',
            'classroom_id' => 'required|exists:classrooms,id',
            'enrollment_date' => 'required|date',
        ]);

        $student->update([
            'first_name' => $request->input('first_name'),
            'surname' => $request->input('surname'),
            'student_num' => $request->input('student_num'),
            'birth_date' => $request->input('birth_date'),
            'address' => $request->input('address'),
            'parent_phone_number' => $request->input('parent_phone_number'),
            'second_phone_number' => $request->input('second_phone_number'),
            'gender' => $request->input('gender'),
            'classroom_id' => $request->input('classroom_id'),
            'enrollment_date' => $request->input('enrollment_date'),
        ]);

        return response()->json(['message' => 'Student updated successfully', 'student' => $student]);
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return response()->json(['message' => 'Student deleted successfully']);
    }
}

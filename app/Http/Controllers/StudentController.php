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
        try {
            $validatedData = $request->validate([
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

            $student = Student::create($validatedData);

            return response()->json(['message' => 'Student created successfully', 'student' => $student]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Validation failed
            return response()->json(['message' => 'Validation failed', 'errors' => $e->validator->errors()], 422);
        } catch (\Exception $e) {
            // Other exceptions
            return response()->json(['message' => 'Error creating student', 'error' => $e->getMessage()], 500);
        }
    }


    public function show(Student $student)
    {
        return response()->json(['student' => $student]);
    }

    public function update(Request $request, Student $student)
    {
        $validatedData = $request->validate([
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

        $student->update($validatedData);

        return response()->json(['message' => 'Student updated successfully', 'student' => $student]);
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return response()->json(['message' => 'Student deleted successfully']);
    }
}

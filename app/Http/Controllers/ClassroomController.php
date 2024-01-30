<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ClassroomController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt', ['except' => []]);
    }

    public function index()
    {
        $classrooms = Classroom::all();
        return response()->json(['classrooms' => $classrooms]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'capacity' => 'required|integer',
        ]);

        $classroom = Classroom::create([
            'name' => $request->input('name'),
            'capacity' => $request->input('capacity'),
        ]);

        return response()->json(['message' => 'Classroom created successfully', 'classroom' => $classroom]);
    }

    public function show(Classroom $classroom)
    {
        return response()->json(['classroom' => $classroom]);
    }

    public function update(Request $request, Classroom $classroom)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'capacity' => 'required|integer',
        ]);

        $classroom->update([
            'name' => $request->input('name'),
            'capacity' => $request->input('capacity'),
        ]);

        return response()->json(['message' => 'Classroom updated successfully', 'classroom' => $classroom]);
    }

    public function destroy(Classroom $classroom)
    {
        $classroom->delete();
        return response()->json(['message' => 'Classroom deleted successfully']);
    }

    public function assignStudents(Request $request, Classroom $classroom)
    {
        $request->validate([
            'students' => 'required|array',
            'students.*' => Rule::exists('students', 'id'),
        ]);

        $classroom->students()->sync($request->input('students'));

        return response()->json(['message' => 'Students assigned to the classroom successfully', 'classroom' => $classroom]);
    }

    public function assignTeachers(Request $request, Classroom $classroom)
    {
        $request->validate([
            'teachers' => 'required|array',
            'teachers.*' => Rule::exists('teachers', 'id'),
        ]);

        $classroom->teachers()->sync($request->input('teachers'));

        return response()->json(['message' => 'Teachers assigned to the classroom successfully', 'classroom' => $classroom]);
    }
}

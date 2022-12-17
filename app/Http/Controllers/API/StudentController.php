<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function index(){
        $students = Student::all();
        return response()->json([
            'status'=> 200,
            'students'=>$students,
        ]);
    }
    
    public function store(Request $request){

        $validateData = $request->validate([
            'name'=>'required|max:191',
            'course'=>'required|max:191',
            'email'=>'required|email|max:191|unique:students,email',
            'phone'=>'required|max:11|min:11',
           ]);

        $student = new Student;
        $student->name = $request->input('name');
        $student->email = $request->input('email');
        $student->phone = $request->input('phone');
        $student->course = $request->input('course');
        $student->save();

        return response()->json([
            'status'=>200,
            'message'=>'Student added successfully'
        ]);
    }

    public function edit($id){
        $student = Student::find($id);
        return response()->json([
            'status'=>200,
            'student'=>$student,
        ]);

    }

    public function update(Request $request, $id)
    {
        $validateData = $request->validate([
            'name'=>'required|max:191',
            'course'=>'required|max:191',
            'email'=>'required|email|max:191|unique:students,email',
            'phone'=>'required|max:11|min:11',
           ]);

        $student = Student::find($id);
        if($student)
        {

            $student->name = $request->input('name');
            $student->course = $request->input('course');
            $student->email = $request->input('email');
            $student->phone = $request->input('phone');
            $student->update();

            return response()->json([
                'status'=> 200,
                'message'=>'Student Updated Successfully'
            ]);
        }
        
    }

    public function destroy($id){
        $student = Student::find($id);
        if($student){
            $student->delete();

            return response()->json([
                'status'=>200,
                'message'=>'Student Deleted Successfully'
            ]);
        }else{
            return response()->json([
                'status'=>404,
                'message'=>'No Student ID found'
            ]);
        }
       
    }

}

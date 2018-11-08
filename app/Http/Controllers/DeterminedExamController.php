<?php

namespace App\Http\Controllers;

use App\DeterminedExam;
use Illuminate\Http\Request;

class DeterminedExamController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get all Exams.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAll()
    {
        //If can get all Exams
       if ($exams = DeterminedExam::get()) {
           //Return Exams, 200
           return response()->json($exams, 200);
       } else {
           //Return 500
           return response()->json(array(), 500);
       }
    }

    /**
     * Get all Exams, little data as possible.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllTrimmed()
    {
        //If can get all Exams
        if($data = DeterminedExam::select('_id', 'exam_title', 'exam_description', 'exam_cohort')->get()) {
            //return all trimmed Exams, 200
            return response()->json($data, 200);
        } else {
            //return 500
            return response()->json(array(), 500);
        }
    }

    /**
     * Find exam by id.
     *
     * @param $exam_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getById($exam_id)
    {
        //If can find exam by id
        if($data = DeterminedExam::find($exam_id)) {
            //Return exam, 200
            return response()->json($data, 200);
        } else {
            //Return 404
            return response()->json(new \stdClass(),404);
        }
    }

    public function createExam(Request $request){
        //Get and validate request data
        $data = $this->validate($request, [
            'exam_title' => 'required',
            'exam_description' => 'required',
            'exam_cohort' => 'required']);

        if($determined_exam = DeterminedExam::create($data)) {
            //save created exam, 200
            return response()->json($determined_exam, 200);
        }else {
            //return 500
            return response()->json(array(), 500);
        }
    }
}

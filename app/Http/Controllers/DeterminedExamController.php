<?php

namespace App\Http\Controllers;

use App\DeterminedExam;
use App\FinalAssessment;
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
     * Get all DeterminedExam's (Full)
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
     * Get all DeterminedExam's (Trimmed)
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
     * Find DeterminedExam by ID
     *
     * @param $determined_exam_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getById($determined_exam_id)
    {
        //If can find exam by id
        if($data = DeterminedExam::find($determined_exam_id)) {
            //Return exam, 200
            return response()->json($data, 200);
        } else {
            //Return 404
            return response()->json(new \stdClass(),404);
        }
    }

    /**
     * Update DeterminedExam by ID
     *
     * @param $determined_exam_id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update($determined_exam_id, Request $request)
    {
        if($determined_exam = DeterminedExam::find($determined_exam_id)) {
            //Found DeterminedExam

            //If a Examination has already been started using the DeterminedExam, return 405
            if($final_assessments = FinalAssessment::where('determined_exam_id', '=', $determined_exam_id)->get()->count() > 0)
                return response()->json(array(), 405);



            //Validate request data
            $request_data = $this->validate($request, [
                'exam_title' => '',
                'exam_description' => '',
                'exam_cohort' => '',
                'exam_rating_algorithms' => '',
                'exam_criteria' => ''
            ]);

            //Isset exam_title, update
            if(isset($request_data['exam_title']))
                $determined_exam->exam_title = $request_data['exam_title'];

            //Isset exam_description, update
            if(isset($request_data['exam_description']))
                $determined_exam->exam_description = $request_data['exam_description'];

            //Isset exam_cohort, update
            if(isset($request_data['exam_cohort']))
                $determined_exam->exam_cohort = $request_data['exam_cohort'];

            //Isset exam_rating_algorithms, update
            if(isset($request_data['exam_rating_algorithms']))
                $determined_exam->exam_rating_algorithms = $request_data['exam_rating_algorithms'];

            //Isset exam_criteria, update
            if(isset($request_data['exam_criteria']))
                $determined_exam->exam_criteria = $request_data['exam_criteria'];

            //Save
            if($determined_exam->save()) {
                //Success, Return 200
                return response()->json($determined_exam, 200);
            } else {
                //Fail, return 505
                return response()->json($determined_exam, 505);
            }
        } else {
            //Return 404
            return response()->json(new \stdClass(), 404);
        }
    }
}

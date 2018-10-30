<?php

namespace App\Http\Controllers;

use App\DeterminedExam;

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
     */
    public function update($determined_exam_id, Request $request)
    {
        if($determined_exam = DeterminedExam::find($determined_exam_id)) {
            return response()->json($determined_exam, 200);
        } else {
            //Return 404
            return response()->json(new \stdClass(), 404);
        }
    }
}

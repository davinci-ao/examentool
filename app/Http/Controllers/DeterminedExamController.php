<?php

namespace App\Http\Controllers;

use App\DeterminedExam;
use http\Env\Request;

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

   public function getAll()
   {
       return response()->json(DeterminedExam::all());
   }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
   public function getAllTrimmed()
   {
        //if db request is successfull
        if($data = DeterminedExam::select('_id', 'exam_title', 'exam_description', 'exam_cohort')->get()) {
            //If db request returned 0 lines
            if($data->count() == 0) {
                //return 404
                return response()->json(array(), 404);
            } else {
                //return data, 200
                return response()->json($data, 200);
            }
        } else {
            //return 500
            return response()->json(array(), 500);
        }
   }

   public function getById($exam_id)
   {

   }
}

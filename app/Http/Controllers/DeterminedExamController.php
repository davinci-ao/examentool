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
       if ($exams = DeterminedExam::get()) {
           return response()->json($exams, 200);
       } else {
           return response()->json(array(), 500);
       }
   }

   public function getAllTrimmed()
   {
        
   }

   public function getById($exam_id)
   {

   }
}

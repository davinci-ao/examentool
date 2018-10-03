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

   public function getAllTrimmed()
   {
        
   }

   public function getById($exam_id)
   {

   }
}

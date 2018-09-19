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

    public function index()
    {
        return DeterminedExam::all();
    }

    public function view($id)
    {
        return DeterminedExam::find($id);
    }

    public function create(Request $request)
    {
        return response()->json(DeterminedExam::create($request->all(), 201));
    }
}

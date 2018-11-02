<?php

namespace App\Http\Controllers;

use App\Assessment;
use App\FinalAssessment;
use App\DeterminedExam;
use Illuminate\Http\Request;

class AssessmentController extends Controller
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
     * Start assement
     *
     * @param $exam_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function startAssessment($exam_id)
    {
        //Find if exam exists
        if($determined_exam = DeterminedExam::find($exam_id)) {

            //Make final assessment
            $final_assessment = new FinalAssessment();

            $final_assessment->exam_title = $determined_exam->exam_title;
            $final_assessment->exam_description = $determined_exam->exam_description;
            $final_assessment->student_number = "";
            $final_assessment->examinators = array();
            $final_assessment->exam_cohort = $determined_exam->exam_cohort;
            $final_assessment->determined_exam_id  = $determined_exam->_id;
            $final_assessment->exam_rating_algorithms  = $determined_exam->exam_rating_algorithms;
            $final_assessment->exam_criteria  = $determined_exam->exam_criteria;
            $final_assessment->result = "";
            $final_assessment->finished = False;
            $final_assessment->date = date("Y-m-d: H-i-s");

            //Insert Final assessment
            if($final_assessment->save()) {
                return response()->json($final_assessment, 201);
            } else {
                //Return 500, error saving
                return response()->json(array(), 500);
            }

        } else {
            //Return 404, entry not found
            return response()->json(array(), 404);
        }
    }

    /**
     * Get all FinalAssessments
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllFinalAssessments() {
        if($data = FinalAssessment::all()) {
            //return all trimmed Exams, 200
            return response()->json($data, 200);
        } else {
            //return 500
            return response()->json(array(), 500);
        }
    }

    /**
     * Join in on an Assessment
     *
     * @param $final_assessment_id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function joinAssessment($final_assessment_id, Request $request) {

        //Get and validate request data
        $request_data = $this->validate($request, [
            'examinator_name' => 'required',
        ]);

        //Find FinalAssessment
        if($final_assessment = FinalAssessment::find($final_assessment_id)) {
            //If FinalAssessment is finished, return 403
            if($final_assessment->finished == true){
                return response()->json(array(), 403);
            } else {
                //Check if user already has an assessment for this Final Assessment
                if($assessment = Assessment::where('examinator', '=', $request_data['examinator_name'])->get()) {

                    //If no entries found
                    if($assessment->count() == 0) {
                        //Make empty assessment
                        $assessment = new Assessment();

                        //Set data in assessment
                        $assessment->exam_title = $final_assessment->exam_title;
                        $assessment->exam_description = $final_assessment->exam_description;
                        $assessment->student_number = $final_assessment->student_number;
                        $assessment->examinator = $request_data['examinator_name'];//Insert current user id or object when user system integrated!!
                        $assessment->exam_cohort = $final_assessment->exam_cohort;
                        $assessment->final_assessment_id = $final_assessment->_id;
                        $assessment->exam_rating_algorithms = $final_assessment->exam_rating_algorithms;
                        $assessment->finished = False;
                        $assessment->date = $final_assessment->date;
                        //Make empty variable to store modified criteria sections with criteria in
                        $criterias = array();

                        //Loop through all criteria sections
                        foreach ($final_assessment->exam_criteria as $criteria_section) {
                            //Create variable to temporary store criteria section criterias
                            $new_criterias = array();
                            //Loop through all criterias in a criteria section
                           foreach($criteria_section['criteria'] as $criteria) {
                               //Add extra data fields to criteria
                                $criteria['doubt'] = False;
                                $criteria['answer'] = Null;
                                $criteria['examinator_notes'] = "";
                                //Push to temproary criteria variable $new_criterias
                                array_push($new_criterias, $criteria);
                           }
                           $criteria_section['criteria'] = $new_criterias;
                           //Push criteria section to $criterias variable
                           array_push($criterias, $criteria_section);
                        }
                        //Place modified criterias in Assessment 
                        $assessment->exam_criteria = $criterias;

                        //Insert assessment
                        if($assessment->save()) {
                            //Update examinators araray in Final Assessment
                            $examinators = $final_assessment->examinators;
                            array_push($examinators, $request_data['examinator_name']);
                            $final_assessment->examinators = $examinators;
                            $final_assessment->save();

                            //Return
                            return response()->json($assessment, 201);
                        } else {
                            //Return 500
                            return response()->json(array(), 500);
                        }
                    } else {
                        //Pull object out of the array MongoDB returns
                        $assessment = $assessment[0];

                        //Return found assessment
                        return response()->json($assessment, 200);
                    }

                } else {
                    //Return 500
                    return response()->json(array(), 500);
                }
            }
        } else {
            //Return 404 if no FinalAssessment found
            return response()->json(array(), 404);
        }
    }

}

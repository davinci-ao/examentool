<?php

namespace App\Http\Controllers;

use App\Assessment;
use App\FinalAssessment;
use App\DeterminedExam;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Boolean;

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
     * Start assessment
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

            $determined_exam->editable = false;

            $final_assessment->exam_title = $determined_exam->exam_title;
            $final_assessment->exam_description = $determined_exam->exam_description;
            $final_assessment->student_number = "";
            $final_assessment->examiners = array();
            $final_assessment->exam_cohort = $determined_exam->exam_cohort;
            $final_assessment->determined_exam_id  = $determined_exam->_id;
            $final_assessment->exam_rating_algorithms  = $determined_exam->exam_rating_algorithms;
            $final_assessment->exam_criteria  = $determined_exam->exam_criteria;
            $final_assessment->result = "";
            $final_assessment->finished = false;
            $final_assessment->date = date("Y-m-d: H-i-s");

            //Insert Final assessment
            if($final_assessment->save() && $determined_exam->save()) {
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
    public function getAllFinalAssessments()
    {
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
    public function joinAssessment($final_assessment_id, Request $request)
    {

        //Get and validate request data
        $request_data = $this->validate($request, [
            'examiner_name' => 'required',
        ]);

        //Find FinalAssessment
        if($final_assessment = FinalAssessment::find($final_assessment_id)) {
            //If FinalAssessment is finished, return 403
            if($final_assessment->finished == true){
                return response()->json(array(), 403);
            } else {
                //Check if user already has an assessment for this Final Assessment
                if($assessment = Assessment::where('final_assessment_id', '=', $final_assessment_id)->where('examiner', '=', $request_data['examiner_name'])->get()) {

                    //If no entries found
                    if($assessment->count() == 0) {
                        //Check how many assessments already exits
                        if(Assessment::where('final_assessment_id', '=', $final_assessment_id)->get()->count() == 2) {
                            return response()->json(array(), 403);
                        } else {
                            //Make empty assessment
                            $assessment = new Assessment();

                            //Set data in assessment
                            $assessment->exam_title = $final_assessment->exam_title;
                            $assessment->exam_description = $final_assessment->exam_description;
                            $assessment->student_number = $final_assessment->student_number;
                            $assessment->examiner = $request_data['examiner_name'];//Insert current user id or object when user system integrated!!
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
                                    $criteria['examiner_notes'] = "";
                                    //Push to temporary criteria variable $new_criterias
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
                                //Update examiners array in Final Assessment
                                $examiners = $final_assessment->examiners;
                                array_push($examiners, $request_data['examiner_name']);
                                $final_assessment->examiners = $examiners;
                                $final_assessment->save();

                                //Return
                                return response()->json($assessment, 201);
                            } else {
                                //Return 500
                                return response()->json(array(), 500);
                            }

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

    /**
     * Update Assessment by id
     *
     * @param $assessment_id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateAssessment($assessment_id, Request $request){
        //Validate request data
        $request_data = $this->validate($request, [
            'exam_criteria' => 'required'
        ]);

        //Find existing assessment
        $assessment = Assessment::find($assessment_id);

        if($assessment) {

            $finalAssessment = FinalAssessment::find($assessment->final_assessment_id);

            if(($finalAssessment->finished && $assessment->finished) == false) {

                //Make variables for looping
                $assessment_criteria = $assessment->exam_criteria;
                $new_assessment_criteria = array();

                //Loop through criteria sections
                for($a = 0; $a < count($assessment_criteria); $a++) {

                    //Make section variable and set the title
                    $section = new \stdClass();
                    $section->title = $assessment_criteria[$a]['title'];

                    //Make criteria variables for looping
                    $criteria = $assessment_criteria[$a]['criteria'];
                    $new_criteria = array();

                    //Loop through criteria for this criteria section
                    for($b = 0; $b < count($criteria); $b++) {
                        //Make variable to update current criteria
                        $single_criteria = new \stdClass();

                        //Update properties of current criteria (NOT EDITABLE ONES)
                        $single_criteria->criteria_name = $criteria[$b]['criteria_name'];
                        $single_criteria->criteria_description = $criteria[$b]['criteria_description'];
                        $single_criteria->rating_group = $criteria[$b]['rating_group'];
                        $single_criteria->show_stopper = $criteria[$b]['show_stopper'];

                        //Update properties of current criteria (EDITABLE)
                        $single_criteria->doubt = $request_data['exam_criteria'][$a]['criteria'][$b]['doubt'];
                        $single_criteria->answer = $request_data['exam_criteria'][$a]['criteria'][$b]['answer'];
                        $single_criteria->examiner_notes = $request_data['exam_criteria'][$a]['criteria'][$b]['examiner_notes'];

                        //Push updated criteria into criteria section
                        array_push($new_criteria, $single_criteria);
                    }

                    $section->criteria = $new_criteria;

                    //Push criteria section into criteria list
                    array_push($new_assessment_criteria, $section);
                }

                //Update criteria array in Assessment object
                $assessment->exam_criteria = $new_assessment_criteria;

                //If student number is set update
                if(isset($request_data['student_number']))
                    $assessment->student_number = $request_data['student_number'];

                //Update
                if($assessment->update()) {
                    //Return updated assessment
                    return response()->json($assessment, 200);
                } else {
                    //Return 500
                    return response()->json(array(), 500);
                }
            } else {
                return response()->json(array(), 405);
            }
        } else {
            //Return 404
            return response()->json(array(), 404);
        }


    }

    /**
     * Finish Assessment
     *
     * @param $assessment_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function finishAssessment($assessment_id) {
        $assessment = Assessment::find($assessment_id);
        if($assessment) {
            $assessment->finished = true;
            if($assessment->save()) {
                return response()->json($assessment, 200);
            } else {
                return response()->json(array(), 500);
            }
        } else {
            return response()->json(array(), 404);
        }
    }

    /**
     * Check if all Assessments for FinalAssessment are finished
     *
     * @param $assessment_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function check($assessment_id, $json = true) {
        $assessment = Assessment::find($assessment_id);
        if($assessment) {
            $assessments = Assessment::where('final_assessment_id', '=', $assessment->final_assessment_id)->get();
            if($assessments->count() < 2) {
                if($json) {
                    return response()->json(array("message"=> "missing"), 405);
                } else {
                    return false;
                }
            } else {
                $finished = true;
                foreach ($assessments as $assessment) {
                    if($assessment->finished == false) {
                        $finished = false;
                    }
                }
                if($finished == false) {
                    if($json) {
                        return response()->json(array("message" => "unfinished"), 405);
                    } else {
                        return false;
                    }
                } else {
                    if($json) {
                        return response()->json(array("message" => "finished"), 200);
                    } else {
                        return $assessments;
                    }
                }
            }
        } else {
            return response()->json(array(), 404);
        }
    }

    /**
     * @param $assessment_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function startFinalAssessment($assessment_id) {
        $assessment = Assessment::find($assessment_id);
        if($assessment) {
            $assessments = Self::check($assessment_id, false);
            if($assessments) {
                //both asssessments are finished
                $finalAssessment = Self::combineAssessments($assessments[0], $assessments[1]);

                if($finalAssessment) {
                    //Error bij combining the assessments to the FinalAssessment
                    return response()->json(array(), 500);
                } else {
                    return response()->json($finalAssessment, 200);
                }
            } else {
                return response()->json(array(), 405);
            }
        } else {
            return response()->json(array(), 404);
        }
    }

    /**
     * @param $final_assessment_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getFinalAssessmentById($final_assessment_id) {
        $finalAssessment = FinalAssessment::find($final_assessment_id);

        if($finalAssessment) {
            return response()->json($finalAssessment, 200);
        } else {
            return response()->json(array(), 404);
        }
    }
  
    /**
     * Get processReport
     *
     * @param $final_assessment_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProcessReport($final_assessment_id) {
        return response()->json(array('processReport' => FinalAssessment::find($final_assessment_id)->processReport), 200);
    }

    /**
     * Set processReport
     *
     * @param $final_assessment_id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function setProcessReport($final_assessment_id, Request $request) {
        //Validate request data
        $request_data = $this->validate($request, [
            'processReport' => 'required'
        ]);

        $final_assessment = FinalAssessment::find($final_assessment_id);
        $final_assessment->processReport = $request_data['processReport'];

        //Update
        if($this->endAssessment($final_assessment_id) and $final_assessment->update()) {
            //Return updated assessment
            return $this->getProcessReport($final_assessment_id);
        } else {
            //Return 500
            return response()->json(array(), 500);
        }
    }

    /**
     * @param Assessment $assessment_1
     * @param Assessment $assessment_2
     * @return bool
     */
    private function combineAssessments(Assessment $assessment_1, Assessment $assessment_2) {
        //Check if both assessments are from the same final assessment!
        if($assessment_1->final_assessment_id === $assessment_2->final_assessment_id) {
            $final_assessment = FinalAssessment::find($assessment_1->final_assessment_id);

            $criteria = Array();

            for($section = 0; $section < count($final_assessment->exam_criteria); $section++) {
                $assessment_section = new \stdClass();
                $assessment_section->title = $final_assessment->exam_criteria[$section]['title'];

                $assessment_section->criteria = Array();

                for($b = 0; $b < count($final_assessment->exam_criteria[$section]['criteria']); $b++) {
                    $assessment_1_criterion = $assessment_1->exam_criteria[$section]['criteria'][$b];
                    $assessment_2_criterion = $assessment_2->exam_criteria[$section]['criteria'][$b];

                    $criterion = new \stdClass();
                    $criterion->criteria_name = $final_assessment->exam_criteria[$section]['criteria'][$b]['criteria_name'];
                    $criterion->criteria_description = $final_assessment->exam_criteria[$section]['criteria'][$b]['criteria_description'];
                    $criterion->rating_group = $final_assessment->exam_criteria[$section]['criteria'][$b]['rating_group'];
                    $criterion->show_stopper = $final_assessment->exam_criteria[$section]['criteria'][$b]['show_stopper'];

                    if($assessment_1_criterion['answer'] == $assessment_2_criterion['answer']) {
                        $criterion->doubt = false;
                        $criterion->answer = $assessment_1->exam_criteria[$section]['criteria'][$b]['answer'];

                    } else {
                        $criterion->doubt = true;
                        $criterion->answer = null;
                    }
                    $criterion->examiners = Array();

                    foreach($final_assessment->examiners as $examiner) {
                        $examiner_results = new \stdClass();
                        $examiner_results->name = $examiner;

                        if($assessment_1->examiner == $examiner) {
                            $examiner_results->answer = $assessment_1_criterion['answer'];
                            $examiner_results->notes = $assessment_1_criterion['examiner_notes'];
                        } else if($assessment_2->examiner == $examiner) {
                            $examiner_results->answer = $assessment_2_criterion['answer'];
                            $examiner_results->notes = $assessment_2_criterion['examiner_notes'];
                        }


                        array_push($criterion->examiners, $examiner_results);
                    }

                    array_push($assessment_section->criteria, $criterion);
                }
                array_push($criteria, $assessment_section);
            }

            $final_assessment->exam_criteria = $criteria;

            if($final_assessment->save()) {
                return $final_assessment;
            } else {
                return false;
            }
        } else {
            //Assessments are from different Final Assessments
            return false;
        }
    }
}
    /**
     * End assessment
     *
     * @param $final_assessment_id
     * @return Bool
     */
    private function endAssessment($final_assessment_id) {
        $final_assessment = FinalAssessment::find($final_assessment_id);
        $final_assessment->finished = true;

        $assessments = Assessment::where('final_assessment_id', '=', $final_assessment_id)->get();
        foreach ($assessments as $assessment) {
            $assessment->finished = true;
            if(!$assessment->update()) {
                return false;
            }
        }

        if($final_assessment->update()) {
            return true;
        } else {
            return false;
        }
    }
}

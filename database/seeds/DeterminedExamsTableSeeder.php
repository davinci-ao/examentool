<?php

use Illuminate\Database\Seeder;

class DeterminedExamsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $algorithms = new stdClass();
        $algorithms->fail = "Algoritme voor onvoldoende";
        $algorithms->pass = "Algoritme voor voldoende";
        $algorithms->good = "Algoritme voor goed";

        $exam_section_one_criteria_one = new stdClass();
        $exam_section_one_criteria_one->criteria_name = "Criteria 1";
        $exam_section_one_criteria_one->criteria_description = "Criteria 1 voor sectie 1, voor fail groep";
        $exam_section_one_criteria_one->rating_group = "fail";
        $exam_section_one_criteria_one->show_stopper = False;

        $exam_section_one_criteria_two = new stdClass();
        $exam_section_one_criteria_two->criteria_name = "Criteria 2";
        $exam_section_one_criteria_two->criteria_description = "Criteria 2 voor sectie 1";
        $exam_section_one_criteria_two->rating_group = "pass";
        $exam_section_one_criteria_two->show_stopper = False;


        $exam_section_two_criteria_one = new stdClass();
        $exam_section_two_criteria_one->criteria_name = "Show stopper";
        $exam_section_two_criteria_one->criteria_description = "Show stopper";
        $exam_section_two_criteria_one->rating_group = "fail";
        $exam_section_two_criteria_one->show_stopper = True;

        $exam_section_two_criteria_two = new stdClass();
        $exam_section_two_criteria_two->criteria_name = "Good criteria";
        $exam_section_two_criteria_two->criteria_description = "Criteria van de \"good\" group";
        $exam_section_two_criteria_two->rating_group = "fail";
        $exam_section_two_criteria_two->show_stopper = True;

        $data = array(
            "exam_title" => "Examen 1",
            "exam_description" => "Beschrijving voor examen 1",
            "exam_cohort" => 2016,
            "exam_rating_algorithms" => $algorithms,
            "exam_criteria" => Array(
                "section_one" => array($exam_section_one_criteria_one, $exam_section_one_criteria_two),
                "section_two" => array($exam_section_two_criteria_one, $exam_section_two_criteria_two)
            )
        );

        App\DeterminedExam::create($data);

        //-------------------------//

        $algorithms = new stdClass();
        $algorithms->fail = "Algoritme voor onvoldoende";
        $algorithms->pass = "Algoritme voor voldoende";
        $algorithms->good = "Algoritme voor goed";

        $exam_section_one_criteria_one = new stdClass();
        $exam_section_one_criteria_one->criteria_name = "Criteria 1";
        $exam_section_one_criteria_one->criteria_description = "Criteria 1 voor sectie 1, voor fail groep";
        $exam_section_one_criteria_one->rating_group = "fail";
        $exam_section_one_criteria_one->show_stopper = False;

        $exam_section_one_criteria_two = new stdClass();
        $exam_section_one_criteria_two->criteria_name = "Criteria 2";
        $exam_section_one_criteria_two->criteria_description = "Criteria 2 voor sectie 1";
        $exam_section_one_criteria_two->rating_group = "pass";
        $exam_section_one_criteria_two->show_stopper = False;

        $exam_section_two_criteria_one = new stdClass();
        $exam_section_two_criteria_one->criteria_name = "Show stopper";
        $exam_section_two_criteria_one->criteria_description = "Show stopper";
        $exam_section_two_criteria_one->rating_group = "fail";
        $exam_section_two_criteria_one->show_stopper = True;

        $exam_section_two_criteria_two = new stdClass();
        $exam_section_two_criteria_two->criteria_name = "Good criteria";
        $exam_section_two_criteria_two->criteria_description = "Criteria van de \"good\" group";
        $exam_section_two_criteria_two->rating_group = "fail";
        $exam_section_two_criteria_two->show_stopper = True;

        $data = array(
            "exam_title" => "Examen 2",
            "exam_description" => "Beschrijving voor examen 2",
            "exam_cohort" => 2017,
            "exam_rating_algorithms" => $algorithms,
            "exam_criteria" => Array(
                "section_one" => array($exam_section_one_criteria_one, $exam_section_one_criteria_two),
                "section_two" => array($exam_section_two_criteria_one, $exam_section_two_criteria_two)
            )
        );

        App\DeterminedExam::create($data);
    }
}

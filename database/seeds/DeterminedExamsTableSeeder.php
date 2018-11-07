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
        $algorithms->fail = "onv > 2 of vold + goed - onv < 12, of een show stopper";
        $algorithms->pass = "vold + goed - onv > 12 en onv < 2 en (vold - onv < 12 of goed < 4), geen showstopper";
        $algorithms->good = "onv = 0 en vold = 12 en goed > 4, geen showstoppers";

        $exam_section_one = new stdClass();
        $exam_section_one->title = "Broncode";

        $exam_section_one_criteria_one = new stdClass();
        $exam_section_one_criteria_one->criteria_name = "Version Control";
        $exam_section_one_criteria_one->criteria_description = "De kandidaat slaat zijn/haar code op in een version control ssyteem.";
        $exam_section_one_criteria_one->rating_group = "pass";
        $exam_section_one_criteria_one->show_stopper = False;

        $exam_section_one_criteria_two = new stdClass();
        $exam_section_one_criteria_two->criteria_name = "Commits";
        $exam_section_one_criteria_two->criteria_description = "De kandidaat checkt meerdere keren per week substantiele en goed omgschreven commits in.";
        $exam_section_one_criteria_two->rating_group = "good";
        $exam_section_one_criteria_two->show_stopper = False;
        $exam_section_one->criteria = array($exam_section_one_criteria_one, $exam_section_one_criteria_two);

        $exam_section_two = new stdClass();
        $exam_section_two->title = "Database";

        $exam_section_two_criteria_one = new stdClass();
        $exam_section_two_criteria_one->criteria_name = "ERD onderhoud";
        $exam_section_two_criteria_one->criteria_description = "De ERD is niet onderhouden";
        $exam_section_two_criteria_one->rating_group = "fail";
        $exam_section_two_criteria_one->show_stopper = True;

        $exam_section_two_criteria_two = new stdClass();
        $exam_section_two_criteria_two->criteria_name = "ERD";
        $exam_section_two_criteria_two->criteria_description = "De gebruiker heeft een ERD";
        $exam_section_two_criteria_two->rating_group = "pass";
        $exam_section_two_criteria_two->show_stopper = False;
        $exam_section_two->criteria = array($exam_section_two_criteria_one, $exam_section_two_criteria_two);


        $data = array(
            "exam_title" => "Proeve van Bekwaamheid 1",
            "exam_description" => "KT2 (B1-K2): Realiseert en test een applicatie",
            "exam_cohort" => 2016,
            "exam_rating_algorithms" => $algorithms,
            "exam_criteria" => Array(
                $exam_section_one,
                $exam_section_two
            )
        );

        App\DeterminedExam::create($data);

        //-------------------------//

        $algorithms = new stdClass();
        $algorithms->fail = "onv > 2 of vold + goed - onv < 12, of een show stopper";
        $algorithms->pass = "vold + goed - onv > 12 en onv < 2 en (vold - onv < 12 of goed < 4), geen showstopper";
        $algorithms->good = "onv = 0 en vold = 12 en goed > 4, geen showstoppers";

        $exam_section_one = new stdClass();
        $exam_section_one->title = "Broncode";

        $exam_section_one = new stdClass();
        $exam_section_one->title = "section_one";

        $exam_section_one_criteria_one = new stdClass();
        $exam_section_one_criteria_one->criteria_name = "Code geschreven";
        $exam_section_one_criteria_one->criteria_description = "De kandidaat heeft een goede hoeveelheid aan code van het totale project geschreven";
        $exam_section_one_criteria_one->rating_group = "pass";
        $exam_section_one_criteria_one->show_stopper = False;

        $exam_section_one_criteria_two = new stdClass();
        $exam_section_one_criteria_two->criteria_name = "Commits";
        $exam_section_one_criteria_two->criteria_description = "De kandidaat checkt meerdere keren per week substantiele en goed omgschreven commits in.";
        $exam_section_one_criteria_two->rating_group = "good";
        $exam_section_one_criteria_two->show_stopper = False;
        $exam_section_one->criteria = array($exam_section_one_criteria_one, $exam_section_one_criteria_two);

        $exam_section_two = new stdClass();
<<<<<<< HEAD
        $exam_section_two->title = "section_two";
=======
        $exam_section_two->title = "User Interface";
>>>>>>> dev

        $exam_section_two_criteria_one = new stdClass();
        $exam_section_two_criteria_one->criteria_name = "Geen user interface";
        $exam_section_two_criteria_one->criteria_description = "Er is geen user interface";
        $exam_section_two_criteria_one->rating_group = "fail";
        $exam_section_two_criteria_one->show_stopper = True;

        $exam_section_two_criteria_two = new stdClass();
<<<<<<< HEAD
        $exam_section_two_criteria_two->criteria_name = "Good criteria";
        $exam_section_two_criteria_two->criteria_description = "Criteria van de \"good\" group";
        $exam_section_two_criteria_two->rating_group = "fail";
        $exam_section_two_criteria_two->show_stopper = True;
        $exam_section_two->criteria = array($exam_section_two_criteria_one, $exam_section_two_criteria_two);
=======
        $exam_section_two_criteria_two->criteria_name = "Duidelijke interface";
        $exam_section_two_criteria_two->criteria_description = "De user interface is duidelijk";
        $exam_section_two_criteria_two->rating_group = "pass";
        $exam_section_two_criteria_two->show_stopper = False;
        $exam_section_two->criteria = array($exam_section_two_criteria_one, $exam_section_two_criteria_two);

>>>>>>> dev

        $data = array(
            "exam_title" => "Proeve van Bekwaamheid 2",
            "exam_description" => "KT2 (B1-K2): Realiseert en test een applicatie",
            "exam_cohort" => 2017,
            "exam_rating_algorithms" => $algorithms,
            "exam_criteria" => Array(
                $exam_section_one,
                $exam_section_two
            )
        );

        App\DeterminedExam::create($data);
    }
}

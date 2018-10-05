<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Assessments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assessments', function($collection)
        {
            $collection->string('exam_title');
            $collection->string('exam_description');
            $collection->number('exam_cohort');
            $collection->string('exam_rating_algorithms');
            $collection->string('exam_criteria');
            $collection->string('final_assessment_id');
            $collection->string('examinator');
            $collection->string('student_number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}

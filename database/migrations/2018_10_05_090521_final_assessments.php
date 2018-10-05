<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FinalAssessments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('final_assessments', function($collection)
        {
            $collection->string('exam_title');
            $collection->string('exam_description');
            $collection->number('exam_cohort');
            $collection->string('exam_rating_algorithms');
            $collection->string('exam_criteria');
            $collection->string('determined_exam_id');
            $collection->string('examinators');
            $collection->string('student_numer');
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

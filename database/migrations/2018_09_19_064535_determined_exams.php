<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeterminedExams extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('determined_exams', function($collection)
        {
            $collection->string('exam_title');
            $collection->string('exam_description');
            $collection->number('exam_cohort');
            $collection->string('exam_rating_algorithms');
            $collection->string('exam_criteria');
            $collection->boolean('active');
            $collection->boolean('editable');
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

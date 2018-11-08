<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

//Get all exams with criteria trimmed out
$router->get('/exams', [
    'uses' => 'DeterminedExamController@getAllTrimmed'
]);
//Get all exams with all data
$router->get('/exams/full', [
    'uses' => 'DeterminedExamController@getAll'
]);
//Get selected exam by id
$router->get('/exam/{exam_id}', [
    'uses' => 'DeterminedExamController@getById'
]);
//Start exam by id
$router->get('/exam/{exam_id}/start', [
    'uses' => 'AssessmentController@startAssessment'
]);

$router->get('/assessments', [
    'uses' => 'AssessmentController@getAllFinalAssessments'
]);

$router->post('/assessment/{final_assessment_id}/join', [
   'uses' => 'AssessmentController@joinAssessment'
]);

$router->put('/assessment/{assessment_id}/update', [
   'uses' => 'AssessmentController@updateAssessment'
]);

<?php

use App\Controllers\Api\StudentController;
use CodeIgniter\Router\RouteCollection;
use PhpParser\Builder\Namespace_;

/**
 * @var RouteCollection $routes
 */
$routes->group('api',['namespace'=> 'App\Controllers\Api'],function($routes){
    $routes->post('create-student',[StudentController::class,'addStudent']);
    $routes->get('students',[StudentController::class,'listStudents']);
    $routes->get('student/(:num)',[StudentController::class,'getSingleStudentData']);
    $routes->put('student/(:num)',[StudentController::class,'updateStudent']);
    $routes->delete('student/(:num)',[StudentController::class,'deleteStudent']);
});

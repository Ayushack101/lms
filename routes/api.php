<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BoardController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\ClassesController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherAssessmentController;
use App\Http\Controllers\StudentAssessmentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\TeacherCourseController;
use App\Http\Controllers\StudentCourseController;
use Illuminate\Support\Facades\Route;

// Unauthorized routes
Route::post('login', [AuthController::class, 'apiLogin'])->name('api.login');
Route::get('boards', [BoardController::class, 'apiIndex']);
Route::get('classes', [ClassesController::class, 'apiIndex']);
Route::get('sections', [SectionController::class, 'apiIndex']);
Route::get('subjects/{board_id}', [SubjectController::class, 'apiIndex']);
Route::get('books/{subject_id}', [BookController::class, 'apiIndex']);
Route::post('teachers', [TeacherController::class, 'store']);
Route::post('students', [StudentController::class, 'store']);
Route::get('teachers', [TeacherController::class, 'apiIndex']);

// Logout route
Route::middleware('auth:sanctum')->post('logout', [AuthController::class, 'apiLogout'])->name('api.logout');

Route::middleware('auth:sanctum')->group(function () {
    Route::controller(TeacherController::class)->group(function () {
        Route::get('teachers', 'apiIndex')->name('api.teachers.index');
        Route::get('teachers/{id}', 'apiShow')->name('api.teachers.show');
    });

    Route::controller(StudentController::class)->group(function () {
        Route::get('students', 'apiIndex')->name('api.students.index');
        Route::get('students/{id}', 'apiShow')->name('api.students.show');
    });

    // Teacher Course routes
    Route::controller(TeacherCourseController::class)->group(function () {
        Route::get('teacher/course/boards/{teacher_id}', 'boards');
        Route::get('teacher/course/subjects/{teacher_id}', 'subjects');
        Route::get('teacher/course/books/{subject_id}/{teacher_id}', 'books');
        Route::get('teacher/course/contents/{book_id}/{teacher_id}', 'contents');
        Route::get('teacher/course/content-files/{book_id}/{content_id}', 'contentFiles');
    });

    // Student Course routes
    Route::controller(StudentCourseController::class)->group(function () {
        Route::get('student/courses/{student_id}', 'teachersId');
        Route::get('student/courses/boards/{student_id}/{teacher_id}', 'boards');
        Route::get('student/courses/subjects/{teacher_id}/{board_id}', 'subjects');
        Route::get('student/courses/classes/{student_id}/{teacher_id}', 'classes');
        Route::get('student/courses/contents/{teacher_id}/{subject_id}/{class_id}', 'contents');
        Route::get('student/courses/content-files/{teacher_id}/{class_id}/{subject_id}/{content_id}', 'contentFiles');
    });

    // Teacher Assessment routes
    Route::controller(TeacherAssessmentController::class)->group(function () {
        Route::get('teacher/assigned-tests/subjects/{teacher_id}', 'subjects');
        Route::get('teacher/assigned-tests/books/{teacher_id}/{subject_id}', 'books');
        Route::get('teacher/assigned-tests/classes/{subject_id}/{teacher_id}', 'classes');
        Route::get('teacher/assigned-tests/test-types/{book_id}', 'testTypes');
        // assign assessment routes
        Route::post('teacher/assigned-tests/create', "AssignAssessment");
        Route::get('teacher/assigned-tests/all-assigned/{teacher_id}', 'getAssignedAssessments');
        Route::post('teacher/assigned-tests/assigned/edit/{id}', 'editAssignedAssessment');
        Route::get('teacher/assigned-tests/assigned/delete/{id}', 'deleteAssignedAssessment');
    });

    // Student Assessment routes
    Route::controller(StudentAssessmentController::class)->group(function () {
         Route::get('student/assigned-tests/all-assigned/{teacherId}/{bookId}/{sectionId}', 'index');
         Route::get('student/assigned-tests/question/{assessmentId}', 'getquestions');
         Route::post('student/assigned-tests/attempt/{assessmentId}/{studentId}', 'attemptAssessment');
         Route::get('student/assigned-tests/answers/{attemptId}', 'getAnswerByAttemptId');
    });
});




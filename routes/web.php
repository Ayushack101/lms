<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BoardController;
use App\Http\Controllers\BookContentFileController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\ClassesController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherCourseController;
use App\Http\Controllers\AssesmentController;
use Illuminate\Support\Facades\Route;

// Admin Login Routes
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.submit');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/phpinfo', function () {
    phpinfo();
});

Route::prefix('admin')
    ->middleware(['auth', 'role:admin'])
    ->group(function () {
        // Admin dashboard route
        Route::controller((AdminDashboardController::class))->group(function () {
            Route::get('dashboard', 'index')->name('admin.dashboard');
        });

        // Board routes
        Route::controller(BoardController::class)->group(function () {
            Route::get('boards', 'index')->name('boards.index');
            Route::get('boards/create', 'create')->name('boards.create');
            Route::post('boards', 'store')->name('boards.store');
            Route::get('boards/{id}', 'show')->name('boards.show');
            Route::get('boards/get-all', 'getAll')->name('boards.getAll');
            Route::get('boards/{id}/edit', 'edit')->name('boards.edit');
            Route::put('boards/{id}', 'update')->name('boards.update');
            Route::delete('boards/{id}', 'destroy')->name('boards.destroy');
        });

        // Subject routes
        Route::controller(SubjectController::class)->group(function () {
            Route::get('subjects', 'index')->name('subjects.index');
            Route::get('subjects/create', 'create')->name('subjects.create');
            Route::post('subjects', 'store')->name('subjects.store');
            Route::get('subjects/{id}', 'show')->name('subjects.show');
            Route::get('subjects/{id}/edit', 'edit')->name('subjects.edit');
            Route::put('subjects/{id}', 'update')->name('subjects.update');
            Route::delete('subjects/{id}', 'destroy')->name('subjects.destroy');
        });

        // Classes routes
        Route::controller(ClassesController::class)->group(function () {
            Route::get('classes', 'index')->name('classes.index');
            Route::get('classes/create', 'create')->name('classes.create');
            Route::post('classes', 'store')->name('classes.store');
            Route::get('classes/{id}', 'show')->name('classes.show');
            Route::get('classes/{id}/edit', 'edit')->name('classes.edit');
            Route::put('classes/{id}', 'update')->name('classes.update');
            Route::delete('classes/{id}', 'destroy')->name('classes.destroy');
        });

        // Section routes
        Route::controller(SectionController::class)->group(function () {
            Route::get('sections', 'index')->name('sections.index');
            Route::get('sections/create', 'create')->name('sections.create');
            Route::post('sections', 'store')->name('sections.store');
            Route::get('sections/{id}', 'show')->name('sections.show');
            Route::get('sections/{id}/edit', 'edit')->name('sections.edit');
            Route::put('sections/{id}', 'update')->name('sections.update');
            Route::delete('sections/{id}', 'destroy')->name('sections.destroy');
        });

        // Content routes
        Route::controller(ContentController::class)->group(function () {
            Route::get('contents', 'index')->name('contents.index');
            Route::get('contents/create', 'create')->name('contents.create');
            Route::post('contents', 'store')->name('contents.store');
            Route::get('contents/{id}', 'show')->name('contents.show');
            Route::get('contents/{id}/edit', 'edit')->name('contents.edit');
            Route::put('contents/{id}', 'update')->name('contents.update');
            Route::delete('contents/{id}', 'destroy')->name('contents.destroy');
        });

        // Book routes
        Route::controller(BookController::class)->group(function () {
            Route::get('books', 'index')->name('books.index');
            Route::get('books/create', 'create')->name('books.create');
            Route::post('books', 'store')->name('books.store');
            Route::get('books/{id}', 'show')->name('books.show');
            Route::get('books/{id}/edit', 'edit')->name('books.edit');
            Route::put('books/{id}', 'update')->name('books.update');
            Route::delete('books/{id}', 'destroy')->name('books.destroy');
        });

        // Book Content Files
        Route::controller(BookContentFileController::class)->group(function () {
            Route::get('books-content-file', 'allBookContent')->name('books.content.file.all');
            Route::get('books-content-file/id/{id}', 'index')->name('books.content.file.index');
            Route::get('books-content-file/create/{id}', 'create')->name('books.content.file.create');
            Route::get('get-subjects-by-board/{board_id}', 'getSubjectsByBoard')->name('get.subjects.by.board');
            Route::get('get-books-by-subject/{subject_id}', 'getBooksBySubject')->name('get.books.by.subject');
            Route::post('books-content-file', 'store')->name('books.content.file.store');
            Route::get('books-content-file/edit/{id}', 'edit')->name('books.content.file.edit');
            Route::put('books-content-file/{id}', 'update')->name('books.content.file.update');
            Route::delete('books-content-file/{id}', 'destroy')->name('books.content.file.destroy');
        });

        // Teacher routes
        Route::controller(TeacherController::class)->group(function () {
            Route::get('teachers', 'index')->name('teachers.index');
            Route::get('teachers/{id}/edit', 'edit')->name('teachers.edit');
            Route::put('teachers/{id}', 'update')->name('teachers.update');
            Route::delete('teachers/{id}', 'destroy')->name('teachers.destroy');
        });

        // Student routes
        Route::controller(StudentController::class)->group(function () {
            Route::get('students', 'index')->name('students.index');
            Route::get('students/{id}/edit', 'edit')->name('students.edit');
            Route::get('get-sections-by-class/{id}', 'getSectionsByClass')->name('get.sections.by.class');
            Route::put('students/{id}', 'update')->name('students.update');
            Route::delete('students/{id}', 'destroy')->name('students.destroy');
        });

        //Teacher Course routes
        Route::controller(TeacherCourseController::class)->group(function () {
            Route::get('teacher-courses', 'getSubjectId')->name('teacher.courses');
            // Route::get('teacher-courses/{subject_id}', 'index')->name('teacher.courses.index');
        });

        // Assesments routes
        Route::controller(AssesmentController::class)->group(function () {
            Route::get('/test-questions', 'index')->name('assesments.index');
            Route::post("/upload-test-questions", "upload")->name("upload.test.questions");
            Route::post('/test-template/{id}', 'deleteTest')->name('delete.test.template');
            Route::get('/test/{id}/questions', 'getQuestions')->name('get.test.questions');
        });

        // AJAX Routes for Dynamic Dropdowns
        Route::get('/get-subjects/{board_id}', [AssesmentController::class, 'getsubjects'])->name('get.subjects.by.board');
        Route::get('/get-books/{subject_id}', [AssesmentController::class, 'getBooks'])->name('get.books.by.subject');
    });

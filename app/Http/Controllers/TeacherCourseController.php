<?php

namespace App\Http\Controllers;

use App\Http\Resources\BoardResource;
use App\Http\Resources\SubjectResource;
use App\Http\Resources\BookResource;
use App\Http\Resources\ContentResource;
use App\Http\Resources\ContentFilesResource;
use App\Services\TeacherService;
use App\Services\BoardService;
use App\Services\SubjectService;
use App\Services\BookService;
use App\Services\ClassesService;
use App\Services\TeacherCourseService;

class TeacherCourseController extends Controller
{
    public function __construct(private TeacherService $teacherService, private BoardService $boardService, private SubjectService $subjectService, private BookService $bookService, private ClassesService $classesService, private TeacherCourseService $TeacherCourseService)
    {
    }

    public function boards(int $teacher_id)
    {
        $boards = $this->TeacherCourseService->getboardByTeacher($teacher_id);
        return BoardResource::collection($boards);
    }

    public function subjects($teacher_id)
    {
        $subjects = $this->TeacherCourseService->getSubjectsByTeacher($teacher_id);
        return SubjectResource::collection($subjects);
    }

    public function books($subject_id, $teacher_id)
    {
        $books = $this->TeacherCourseService->getBooksByTeacher($subject_id, $teacher_id);
        return BookResource::collection($books);
    }

    public function contents($book_id, $teacher_id)
    {
        $contents = $this->TeacherCourseService->getContentsByTeacher($book_id, $teacher_id);
        return ContentResource::collection($contents);
    }

    public function contentFiles($book_id, $content_id)
    {
        $files = $this->TeacherCourseService->getfilesByContent($book_id, $content_id);
        return ContentFilesResource::collection($files);
    }
}
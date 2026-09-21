<?php

namespace App\Http\Controllers;
use App\Services\StudentCourseServices;
use App\Http\Resources\BoardResource;
use App\Http\Resources\SubjectResource;
use App\Http\Resources\ClassResource;
use App\Services\BoardService;
use App\Services\SubjectService;
use App\Services\BookService;
use App\Http\Resources\ContentResource;
use App\Http\Resources\ContentFilesResource;

class StudentCourseController extends Controller
{
    public function __construct(private StudentCourseServices $StudentCourseService, private BoardService $boardService, private SubjectService $subjectService, private BookService $bookService)
    {
    }

    public function teachersId($id)
    {
        return $this->StudentCourseService->getTeacherIdByStudent($id);
    }

    public function boards($student_id, $teacher_id)
    {
        $board = $this->StudentCourseService->getBoardByTeacherID($teacher_id);
        return BoardResource::collection($board);
    }

    public function subjects($teacher_id, $board_id)
    {
        $subjects = $this->StudentCourseService->getSubjectByTeacherID($teacher_id, $board_id);
        return SubjectResource::collection($subjects);
    }

    public function classes($student_id, $teacher_id)
    {
        $class = $this->StudentCourseService->getclasskByStudentID($student_id, $teacher_id);
        return ClassResource::collection($class);
    }

    public function contents( $teacher_id, $subject_id, $class_id)
    {
        $contents = $this->StudentCourseService->getcontentsByTeacherId( $teacher_id, $subject_id, $class_id);
        return ContentResource::collection($contents);
    }

    public function contentFiles($teacher_id, $class_id, $subject_id, $content_id)
    {
        $files = $this->StudentCourseService->getContentFilesByTeacherId($teacher_id, $class_id, $subject_id, $content_id);
        return ContentFilesResource::collection($files);
    }
}

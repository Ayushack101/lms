<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeacherCoding\TeacherCodingStoreRequest;
use App\Http\Requests\TeacherCoding\TeacherCodingUpdateRequest;
use App\Http\Resources\BookResource;
use App\Http\Resources\ClassResource;
use App\Http\Resources\CodingResource;
use App\Http\Resources\SubjectResource;
use App\Services\TeacherCodingService;
use App\Services\TeacherCourseService;
use Illuminate\Http\Request;

class TeacherCodingController extends Controller
{
    //

    public function __construct(private TeacherCodingService $teacherCodingService, private TeacherCourseService $teacherCourseService)
    {
    }

    public function subjects(int $teacherId)
    {
        $subjects = $this->teacherCourseService->getSubjectsByTeacher($teacherId);
        return SubjectResource::collection($subjects);
    }

    public function books(int $subjectId, int $teacherId)
    {
        $books = $this->teacherCodingService->getBooksByTeacher($subjectId, $teacherId);
        return BookResource::collection($books);
    }

    public function class(int $bookId)
    {
        $class = $this->teacherCodingService->getClassByBookId($bookId);
        return ClassResource::collection($class);
    }
    public function createproject(TeacherCodingStoreRequest $request){
         $projects = $this->teacherCodingService->createProject($request->validated());
         return $projects;

    }
    public function CreatedProjects(int $teacherId){
        $projects = $this->teacherCodingService->getCreatedProjects($teacherId);
        return CodingResource::collection($projects);
    }
    public function updateProject(int $projectId, TeacherCodingUpdateRequest $request){
        $update = $this->teacherCodingService->editProject($projectId, $request->validated());
        return $update;
    }
    public function deleteProject(int $projectId){
        $delete = $this->teacherCodingService->deleteProject($projectId);
        return $delete;
    }
}

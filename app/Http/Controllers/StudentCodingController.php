<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentCoding\StoreStudentCodingRequest;
use App\Services\StudentCodingService;
use Illuminate\Http\Request;

class StudentCodingController extends Controller
{
     public function __construct(private StudentCodingService $studentCodingService)
     {
     }

     public function getProjetcs(int $teacherId, int $classId, int $sectionId ){
          return $this->studentCodingService->getCreatedProject( $teacherId,  $classId, $sectionId);
     }
     public function submitProject(int $projectId, int $studentId, StoreStudentCodingRequest $request){
          return $this->studentCodingService->attemptProject($projectId, $studentId,  $request->validated());
     }
}

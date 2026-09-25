<?php

namespace App\Http\Controllers;
use App\Services\TeacherCourseService;
use App\Services\TeacherAssignmentService;
use Illuminate\Http\Request;

class TeacherAssignmentController extends Controller
{
    //
    public function __construct(private TeacherAssignmentService $teacherAssignmentService,private TeacherCourseService $teacherCourseService)
    {
    }


}

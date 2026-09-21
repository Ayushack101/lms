<?php

namespace App\Http\Controllers;

use App\Http\Requests\Assesments\UploadTestQuestionsRequest;
use Illuminate\Http\Request;
use App\Services\AssesmentService;
use App\Services\BoardService;
use App\Services\BookService;
use App\Services\ClassesService;
use App\Services\SubjectService;
use Illuminate\Http\JsonResponse;
use App\Services\TeacherService;

class AssesmentController extends Controller
{
 
      public function __construct(private AssesmentService $assesmentService, private TeacherService $teacherService, private BoardService $boardService, private SubjectService $subjectService, private BookService $bookService, private ClassesService $classesService)
    {
        
    }
    public function index()
    {
         $data = $this->assesmentService->index();

     return view('Pages.admin.Assesments.index', [
        'boards' => $data['boards'],
        'testTemplates' => $data['testTemplates'],
    ]);
     }

    public function getsubjects(int $board_id)
    {
        $subjects = $this->subjectService->getSubjectsByBoard($board_id);
        return response()->json($subjects);
    }


    public function getBooks(int $subject_id)
    {
        $books = $this->bookService->getBooksBySubject($subject_id);
        return response()->json($books);
    }

    public function upload(UploadTestQuestionsRequest $request){
     
        return  $this->assesmentService->upload($request);
        
    }
    public function deleteTest($id)
    {
        return $this->assesmentService->deleteTest($id);
    }
    public function getQuestions($id)
    {
        return $this->assesmentService->getQuestions($id);
    }

    
   
}

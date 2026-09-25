<?php

namespace App\Services;
use App\Http\Requests\Assesments\UploadTestQuestionsRequest;
use App\Models\Board;
use App\Models\Question;
use App\Models\Subject;
use App\Models\Book;
use App\Models\TestTemplate;
use App\Imports\TestQuestionsImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class AssesmentService
{

     public function index()
    {
         $boards = Board::all();
        $testTemplates = TestTemplate::with('book', 'questions', 'class')->get()->groupBy('book_id');
        return [
            'boards' => $boards,
            'testTemplates' => $testTemplates,
        ];
    }
  public function getSubjectsByBoard($board_id)
    {
        $subjects = Subject::where('board_id', $board_id)->select('id', 'subject_name')->get();
        return $subjects;
    }
     public function getBooksBySubject(int $subject_id)
    {
        return Book::where('subject_id', $subject_id)->get()->load('subject', 'class', 'contents');
    }

     public function upload($request)
    {
        try {
            DB::beginTransaction();

            // Getting class id from book
            $book = Book::find($request->book_id);
            $class_id = $book->class_id;

            $testTemplate = TestTemplate::create([
                'class_id' => $class_id,
                'book_id' => $request->book_id,
                'test_name' => $request->test_name,
                'type' => $request->type,
                'description' => $request->description,
                'status' => 'active',
            ]);

            Excel::import(
                new TestQuestionsImport($testTemplate->id),
                $request->file('questions_sheet')
            );

            DB::commit();

            return redirect()->route('assesments.index')
                ->with('success', 'Test questions uploaded successfully!');
        } catch (\Throwable $exception) {
            DB::rollBack();

            report($exception);

            $message = app()->isLocal()
                ? 'Upload failed: '.$exception->getMessage()
                : 'Upload failed. Please verify the spreadsheet and try again.';

            return redirect()->back()
                ->with('error', $message)
                ->withInput();
        }
    }
    public function getQuestions($id)
    {
        $questions = Question::with('testTemplate')->where('test_template_id', $id)->get();
        return response()->json($questions);
    }

    public function deleteTest($id)
    {
        $test = TestTemplate::findOrFail($id);

        $test->delete();

        return redirect()->back()->with('success', 'Test deleted successfully!');
    }
<<<<<<< HEAD
=======
     
>>>>>>> e88830dedcaf7a4af67a53465706b829da2a1a29
}

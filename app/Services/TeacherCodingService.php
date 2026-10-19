<?php

namespace App\Services;

use App\Models\Book;
use App\Models\Teacher;
use App\Models\TeacherCodingLab;
use Illuminate\Support\Facades\DB;

class TeacherCodingService
{
    /**
     * Create a new class instance.
     */

    public function getBooksByTeacher(int $subjectId,int $teacher_id)
    {
        $teacher = Teacher::find($teacher_id);
        $books = $teacher->books()->where('subject_id', $subjectId)->orderBy('id', 'asc')->get()->load('class');
        return $books;
    }

    public function getClassByBookId(int $bookId){
        $class = Book::where('id', $bookId)->first()->class()->get();
        return $class;
    }

    public function createProject(array $data){
        try{
            DB::beginTransaction();
            $project = TeacherCodingLab::create([
                'title'=> $data['title'],
                'language'=> $data['language'],
                'teacher_id' => $data['teacher_id'],
                'book_id' => $data['book_id'],
                'class_id' => $data['class_id'],
                'section_id' => $data['section_id'],
                'start_date' => $data['start_date'],
                'end_date' => $data['end_date'],
                'questions'=> $data['questions'],
                'description' => $data['description'],
            ]);

            DB::commit();
            return  response()->json([
                'message' => 'Project created successfully',
                'data' => $project
            ],201);

        }catch (\Exception $e){
            DB::rollBack();
            return response()->json([
                'message' => 'Error creating project',
                'error' => $e->getMessage()
            ],500);
        }



    }

    public function getCreatedProjects(int $teacherId){
        $projects = TeacherCodingLab::where('teacher_id', $teacherId)->get();
        return $projects->load([
            'book',
            'class',
            'section'
        ]);
    }

    public function editProject(int $projectId, array $data){
        $project = TeacherCodingLab::where('id', $projectId);
        $project->update($data);
        return response()->json([
            'message' => 'Project updated successfully',
            'data' => $project
        ]);
    }

    public function deleteProject(int $projectId){
        $project = TeacherCodingLab::where('id', $projectId)->delete();
        return response()->json([
            'message' => 'Project deleted successfully'
        ]);
    }


}


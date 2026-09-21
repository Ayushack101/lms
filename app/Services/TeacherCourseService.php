<?php

namespace App\Services;
use App\Models\Content;
use App\Models\Teacher;
use App\Models\BookContentFile;

class TeacherCourseService
{
    public function getboardByTeacher(int $teacher_id)
    {
        $teacher = Teacher::where('id', $teacher_id)->first();

        $boards = $teacher->board()->get();
        return $boards;
    }

    public function getSubjectsByTeacher(int $teacher_id)
    {
        $teacher = Teacher::where('id', $teacher_id)->first();
        $subjects = $teacher->subjects()->orderBy('id', 'asc')->get();
        return $subjects;
    }

    public function getBooksByTeacher(int $subject_id, int $teacher_id)
    {
        $teacher = Teacher::where('id', $teacher_id)->first();
        $books = $teacher->books()->where('subject_id', $subject_id)->orderBy('id', 'asc')->get();
        return $books;
    }

    public function getContentsByTeacher(int $book_id, int $teacher_id)
    {
        $teacher = Teacher::where('id', $teacher_id)->first();
        $contents = $teacher->books()->where('book_id', $book_id)->first()->contents()->whereIn('allow', ['both', 'teacher'])->get(); 
        return $contents;
    }       

    public function getfilesByContent(int $book_id, int $content_id)
    {
        $content = Content::findOrFail($content_id);

        $files = BookContentFile::where('book_id', $book_id)->where('content_id', $content_id)->get();

        $isExtractContent = in_array(
            $content->content_name,
            ['E-book', 'Test Paper Generator']
        );

        return $files->map(function ($file) use ($isExtractContent) {

            $file->file_path = $file->file_path ? asset('storage/' . $file->file_path) : null;

            $file->extract_url = (
                $isExtractContent && $file->extract_path
            )
                ? asset('storage/' . $file->extract_path . '/' . $file->entry_file)
                : null;
            $file->thumbnail = $file->thumbnail ? asset('storage/' . $file->thumbnail) : null;

            return $file;
        });
    }
}
<?php

namespace App\Services;

use App\Models\Book;
use App\Models\Calendar;
use App\Models\Teacher;

class CalendarService
{

     public function getBooksByTeacher(int $subjectId, int $teacher_id)
    {
        $teacher = Teacher::where('id', $teacher_id)->first();
        $books = $teacher->books()->where('subject_id', $subjectId)->with('class')->orderBy('id', 'asc')->get();
        return $books;
    }

    public function getClassByBookId(int $bookId)
    {
        $class = Book::where('id', $bookId)->first()->class()->get();
        return $class;
    }



   // *** Teacher Service class to handle calendar-related operations
    public function getAllEvents(int $teacherId)
    {
        $events = Calendar::where('teacher_id', $teacherId)->get();
        return $events->load([
            'book',
            'class',
            'section'
        ]);
    }

    public function createEvent(array $data)
    {
        $event = Calendar::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'teacher_id' => $data['teacher_id'],
            'book_id' => $data['book_id'],
            'class_id' => $data['class_id'],
            'section_id' => $data['section_id'],
            'type' => $data['type'],
            'date' => $data['date'],
            'start_time' => $data['start_time'],
            'status' => $data['status'],
        ]);

        return response()->json([
        'message' => 'Event created successfully',
        'data' => $event,
        ], 201);
    }

    public function updateEvent(int $eventId, array $data)
    {
        $event = Calendar::findOrFail($eventId);
        $event->update($data);

         return response()->json([
        'message' => 'Event updated successfully',
        'data' => $event,
    ], 201);
    }

    public function deleteEvent(int $eventId)
    {
        $event = Calendar::findOrFail($eventId);
        $event->delete();
        return response()->json([
            'message' => 'Event deleted successfully',
        ], 200);
    }



    // Student Service class to handle calendar-related operations

     public function getStudentEvents(int $teacherId, int $classId, int $sectionId){

        $events = Calendar::where('teacher_id', $teacherId)
            ->where('class_id', $classId)
            ->where('section_id', $sectionId)
            ->get();

        return $events->load([
            'book',
            'class',
            'section'
        ]);
     }

}

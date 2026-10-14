<?php

namespace App\Http\Controllers;

use App\Http\Requests\Calendar\CreateCalendarRequest;
use App\Http\Resources\BookResource;
use App\Http\Resources\CalendarResource;
use App\Http\Resources\ClassResource;
use App\Http\Resources\SubjectResource;
use App\Services\CalendarService;
use App\Services\TeacherCourseService;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
     public function __construct(protected CalendarService $calendarService, protected TeacherCourseService $teacherCourseService)
    {
    }

     public function subjects(int $teacherId)
    {
        $subjects = $this->teacherCourseService->getSubjectsByTeacher($teacherId);
        return SubjectResource::collection($subjects);
    }
    public function books(int $subjectId, int $teacherId){
        $books = $this->calendarService->getBooksByTeacher($subjectId, $teacherId);
        return BookResource::collection($books);
    }
    public function classes(int $bookId){
        $class = $this->calendarService->getClassByBookId($bookId);
        return ClassResource::collection($class);
    }

    public function getAllEvents( int $teacherId)
    {
        $events = $this->calendarService->getAllEvents($teacherId);
        return CalendarResource::collection($events);
    }
    public function createEvent(CreateCalendarRequest $request)
    {
        $event = $this->calendarService->createEvent($request->validated());
        return  $event;
    }
    public function updateEvent(int $eventId, CreateCalendarRequest $request)
    {
        $Updatedevent = $this->calendarService->updateEvent($eventId, $request->validated());
        return $Updatedevent;
    }
    public function deleteEvent(int $eventId)
    {
        $deletedEvent = $this->calendarService->deleteEvent($eventId);
        return $deletedEvent;
    }


    // Student side calendar events
    public function getStudentEvents(int $teacherId, int $classId, int $sectionId)
    {
        $events = $this->calendarService->getStudentEvents($teacherId, $classId, $sectionId);
        return CalendarResource::collection($events);
    }
}

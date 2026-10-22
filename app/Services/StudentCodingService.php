<?php

namespace App\Services;

use App\Models\StudentCodingLabAnswer;
use App\Models\StudentCodingLabAttempt;
use App\Models\TeacherCodingLab;
use Illuminate\Support\Facades\DB;

class StudentCodingService
{
    /**
     * Create a new class instance.
     */
     public function getCreatedProject(int $teacherId, int $classId, int $sectionId){
        $projects = TeacherCodingLab::where('teacher_id', $teacherId)->where('class_id', $classId)->where('section_id', $sectionId)->get();
        return $projects;
     }

     public function attemptProject(int $projectId, int $studentId, array $answers)
    {
        try {
            DB::beginTransaction();

            if (empty($answers['answers'])) {
                throw new \Exception('Answer cannot be empty');
            }

            $attempt = StudentCodingLabAttempt::create([
                'coding_lab_id' => $projectId,
                'student_id' => $studentId,
                'status' => 'submitted',
            ]);

            StudentCodingLabAnswer::create([
                'attempt_id' => $attempt->id,
                'answer' => $answers['answers'],
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Project submitted successfully',
                'attempt_id' => $attempt->id,
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}

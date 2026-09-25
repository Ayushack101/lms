<?php

namespace App\Services;

use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StudentService
{
    public function all(): Collection
    {
        return Student::latest()->get();
    }

    public function paginate(int $perPage = 10, ?string $search = null): LengthAwarePaginator
    {
        $query = Student::latest()->with(['user:id,name,email,role', 'class:id,class_name', 'section:id,section_name', 'teacher:id,teacher_name']);

        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('student_name', 'like', "%{$search}%");
                $query->where('student_mobile', 'like', "%{$search}%");
                $query->where('teacher_code', 'like', "%{$search}%");
                $query->where('teacher_name', 'like', "%{$search}%");
            });
        }

        return Student::paginate($perPage)->withQueryString();
    }

    public function create(array $data): Student
    {
        DB::beginTransaction();
        try {
            $teacher = Teacher::where('teacher_code', $data['teacher_code'])->first();
            if (!$teacher) {
                throw new \Exception('Teacher not found with the provided teacher code.');
            }
            $data['teacher_id'] = $teacher->id;

            $user = User::create([
                'name' => $data['student_name'],
                'email' => $data['student_email'],
                'password' => Hash::make($data['student_password']),
                'role' => 'student',
            ]);

            $data['user_id'] = $user->id;

            $student = Student::create($data);

            DB::commit();

            return $student->load([
                'user',
                'section',
                'teacher',
                'class',
            ]);

        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function find(int $id): Student
    {
        return Student::findOrFail($id)->load([
            'user', 
            'section',
            'teacher',
            'class'
        ]);
    }

    public function update(int $id, array $data): Student
    {
        DB::beginTransaction();

        try {
            $student = Student::findOrFail($id);

            $user = User::findOrFail($student->user_id);

            // Update users table
            $userData = [
                'name' => $data['student_name'],
                'email' => $data['student_email'],
            ];

            if (!empty($data['student_password'])) {
                $userData['password'] = Hash::make($data['student_password']);
            }

            $user->update($userData);

            $teacher = Teacher::findOrFail($data['teacher_id']);

            $studentData = [
                'student_name' => $data['student_name'],
                'student_mobile' => $data['student_mobile'],
                'address' => $data['address'],
                'school_name' => $data['school_name'],
                'status' => $data['status'],
                'class_id' => $data['class_id'],
                'teacher_id' => $teacher->id,
                'section_id' => $data['section_id'],
                'teacher_code' => $teacher->teacher_code,
            ];

            $student->update($studentData);

            DB::commit();

            return $student->fresh(['user']);

        } catch (\Throwable $e) {
            DB::rollBack();

            throw $e;
        }
    }

    public function delete(int $id): bool
    {
        $student = Student::findOrFail($id);
        User::where('id', $student->user_id)->delete();

        return $student->delete();
    }
}

<?php

namespace App\Services;

use App\Models\Teacher;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TeacherService
{
    public function all(): Collection
    {
        return Teacher::latest()->get();
    }

    public function paginate(int $perPage = 10, ?string $search = null): LengthAwarePaginator
    {
        $query = Teacher::latest()->with(['user:id,name,email,role', 'board:id,board_name', 'subjects:id,subject_name', 'books:id,book_name', 'classes:id,class_name']);

        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('teacher_name', 'like', "%{$search}%");
                $query->where('teacher_code', 'like', "%{$search}%");
                $query->where('teacher_mobile', 'like', "%{$search}%");
                $query->where('school_name', 'like', "%{$search}%");
            });
        }

        return Teacher::paginate($perPage)->withQueryString();
    }

    public function create(array $data): Teacher
    {
        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $data['teacher_name'],
                'email' => $data['teacher_email'],
                'password' => Hash::make($data['teacher_password']),
                'role' => 'teacher',
            ]);

            $data['teacher_code'] = 'TE' . strtoupper(uniqid());
            $data['user_id'] = $user->id;

            $teacher = Teacher::create($data);

            foreach ($data['subject_books'] as $subject_book) {
                // Attach subjects to teacher
                $teacher->subjects()->syncWithoutDetaching([$subject_book['subject_id']]);

                foreach ($subject_book['book_ids'] as $book_id) {
                    // Attach books to teacher
                    $teacher->books()->syncWithoutDetaching([$book_id]);
                }
            }

            // Attach classes to teacher
            $teacher->classes()->sync($data['class_ids']);

            DB::commit();

            return $teacher->load([
                'user',
                'board',
                'classes',
                'subjects',
                'books',
            ]);

        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function find(int $id): Teacher
    {
        return Teacher::findOrFail($id);
    }

    public function subjectBooks(int $teacherId): array
    {
        $teacher = Teacher::findOrFail($teacherId);
        $subjectBooks = [];

        foreach ($teacher->subjects as $subject) {
            $subjectBooks[] = [
                'subject_id' => $subject->id,
                'book_ids' => $teacher->books()->where('books.subject_id', $subject->id)->pluck('books.id')->toArray()
            ];

        }
        return $subjectBooks;
    }

    public function update(int $id, array $data): Teacher
    {
        DB::beginTransaction();
        try {
            $teacher = Teacher::findOrFail($id);
            $user = User::where('id', $teacher->user_id)->first();

            // Removing teacher code key
            unset($data['teacher_code']);

            $userData = [
                'name' => $data['teacher_name'],
                'email' => $data['teacher_email'],
            ];

            if (!empty($data['teacher_password'])) {
                $userData['password'] = Hash::make($data['teacher_password']);
            }

            $user->update($userData);

            $teacher->update($data);

            $subjectIds = [];
            $bookIds = [];

            foreach ($data['subject_books'] as $subject_book) {
                $subjectIds[] = $subject_book['subject_id'];

                foreach ($subject_book['book_ids'] as $book_id) {
                    $bookIds[] = $book_id;
                }
            }

            // Attach subjects to teacher
            $teacher->subjects()->sync($subjectIds);

            // Attach books to teacher
            $teacher->books()->sync($bookIds);

            // Attach classes to teacher
            $teacher->classes()->sync($data['class_ids']);

            DB::commit();

            return $teacher->fresh();

        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function delete(int $id): bool
    {
        $teacher = Teacher::findOrFail($id);
        User::where('id', $teacher->user_id)->delete();

        return $teacher->delete();
    }
}

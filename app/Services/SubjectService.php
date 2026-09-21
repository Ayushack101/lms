<?php

namespace App\Services;

use App\Models\Subject;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class SubjectService
{
    public function all(): Collection
    {
        return Subject::latest()->get();
    }

    public function paginate(int $perPage = 10, ?string $search = null): LengthAwarePaginator
    {
        $query = Subject::latest()->with('board');
    
        if ($search) {
            // Group the conditions for subject_name and subject_code using a closure
            $query->where(function ($query) use ($search) {
                $query->where('subject_name', 'like', "%{$search}%")->orWhere('subject_code', 'like', "%{$search}%");
            });
        }

        return $query->paginate($perPage)->withQueryString();
    }

    public function getSubjectsByBoard(int $board_id): Collection
    {
        return Subject::where('board_id', $board_id)->get();
    }

    public function find(int $id): Subject
    {
        return Subject::findOrFail($id);
    }

    public function create(array $data): Subject
    {
        return Subject::create($data);
    }

    public function update(int $id, array $data): Subject
    {
        $subject = Subject::findOrFail($id);
        $subject->update($data);

        return $subject->fresh();
    }

    public function delete(int $id): bool
    {
        $subject = Subject::findOrFail($id);

        return $subject->delete();
    }
}

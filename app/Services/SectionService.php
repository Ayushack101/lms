<?php

namespace App\Services;

use App\Models\Section;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class SectionService
{
    public function all(): Collection
    {
        return Section::latest()->get();
    }

    public function paginate(int $perPage = 10, ?string $search = null): LengthAwarePaginator
    {
        $query = Section::oldest();

        if ($search) {
            $query->where('section_name', 'like', "%{$search}%");
        }

        return $query->paginate($perPage)->withQueryString();
    }

    public function find(int $id): Section
    {
        return Section::findOrFail($id);
    }

    public function getSectionsByClass(int $id): Collection
    {
        return Section::where('class_id', $id)->get();
    }

    public function create(array $data): Section
    {
        return Section::create($data);
    }

    public function update(int $id, array $data): Section
    {
        $section = Section::findOrFail($id);
        $section->update($data);

        return $section->fresh();
    }

    public function delete(int $id): bool
    {
        $section = Section::findOrFail($id);

        return $section->delete();
    }
}

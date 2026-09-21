<?php

namespace App\Services;

use App\Models\Classes;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ClassesService
{
    public function all(): Collection
    {
        return Classes::all();
    }

    public function paginate(int $perPage = 10, ?string $search = null): LengthAwarePaginator
    {
        $query = Classes::oldest();

        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('class_name', 'like', "%{$search}%")
                    ->orWhere('class_position', 'like', "%{$search}%");
            });
        }

        return $query->paginate($perPage)->withQueryString();
    }

    public function find(int $id): Classes
    {
        
        return Classes::findOrFail($id);
    }

    public function create(array $data): Classes
    {
        return Classes::create($data);
    }

    public function update(int $id, array $data): Classes
    {
        $class = Classes::findOrFail($id);
        $class->update($data);

        return $class->fresh();
    }

    public function delete(int $id): bool
    {
        $class = Classes::findOrFail($id);

        return $class->delete();
    }
}

<?php

namespace App\Services;

use App\Models\Content;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class ContentService
{
    public function all(): Collection
    {
        return Content::all();
    }

    public function paginate(int $perPage = 10, ?string $search = null): LengthAwarePaginator
    {
        $query = Content::latest();

        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('content_name', 'like', "%{$search}%")
                    ->orWhere('allow', 'like', "%{$search}%");
            });
        }

        return $query->paginate($perPage)->withQueryString();
    }

    public function find(int $id): Content
    {

        return Content::findOrFail($id);
    }

    public function create(array $data): Content
    {
        return Content::create($data);
    }

    public function update(int $id, array $data): Content
    {
        $content = Content::findOrFail($id);
        $content->update($data);

        return $content->fresh();
    }

    public function delete(int $id): bool
    {
        $content = Content::findOrFail($id);

        return $content->delete();
    }
}

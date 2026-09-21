<?php

namespace App\Services;

use App\Models\BookContentFile;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;

class BookContentFileService
{
    public function all(): Collection
    {
        return BookContentFile::all();
    }

    public function paginate(int $content_id, int $perPage = 10, ?string $search = null): LengthAwarePaginator
    {
        $query = BookContentFile::latest()->with(['content:id,content_name', 'book:id,book_name,subject_id,class_id', 'book.subject:id,subject_name', 'book.class:id,class_name'])->where('content_id', $content_id);

        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        return $query->paginate($perPage)->withQueryString();
    }

    public function find(int $id): BookContentFile
    {
        return BookContentFile::findOrFail($id);
    }

    public function findWithSubjectAndBoard(int $id): BookContentFile
    {
        return BookContentFile::with(['book:id,book_name,subject_id', 'book.subject:id,subject_name,board_id'])->findOrFail($id);

        // Alternative syntax
        BookContentFile::with([
            'book' => function ($query) {
                $query->select('id', 'book_name', 'subject_id')
                    ->with([
                        'subject' => function ($query) {
                            $query->select('id', 'subject_name', 'board_id')
                                ->with('board:id,board_name');
                        }
                    ]);
            }
        ]);
    }

    public function create(array $data): BookContentFile
    {
        return BookContentFile::create($data);
    }

    public function update(int $id, array $data): BookContentFile
    {
        $file = BookContentFile::findOrFail($id);
        $file->update($data);

        return $file->fresh();
    }

    public function delete(int $id): bool
    {
        $file = BookContentFile::findOrFail($id);

        // Delete file from storage
        if ($file->file_path && Storage::disk('public')->exists($file->file_path)) {
            Storage::disk('public')->delete($file->file_path);
        }

        // Delete extracted file from storage
        if ($file->extract_path && Storage::disk('public')->exists($file->extract_path)) {
            Storage::disk('public')->deleteDirectory($file->extract_path);
        }

        // Delete Thumbnail
        if ($file->thumbnail && Storage::disk('public')->exists($file->thumbnail)) {
            Storage::disk('public')->delete($file->thumbnail);
        }

        return $file->delete();
    }
}

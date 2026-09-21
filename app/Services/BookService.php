<?php

namespace App\Services;

use App\Models\Book;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class BookService
{
    public function all(): Collection
    {
        return Book::latest()->get();
    }

    public function paginate(int $perPage = 10, ?string $search = null): LengthAwarePaginator
    {
        $query = Book::latest()->with(['subject', 'class', 'contents']);

        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('book_name', 'like', "%{$search}%");
            });
        }

        return $query->paginate($perPage)->withQueryString();
    }

    public function find(int $id): Book
    {
        return Book::findOrFail($id);
    }

    public function getBooksBySubject(int $subject_id): Collection
    {
        return Book::where('subject_id', $subject_id)->get()->load('subject', 'class', 'contents');
    }

    public function findWithContents(int $id): Book
    {
        return Book::with('contents')->findOrFail($id);
    }

    public function create(array $data): Book
    {
        $book = Book::create($data);

        if (isset($data['content_id'])) {
            $book->contents()->sync($data['content_id']);
        }

        return $book;
    }

    public function update(int $id, array $data): Book
    {
        $book = Book::findOrFail($id);
        $book->update($data);

        if (isset($data['content_id'])) {
            $book->contents()->sync($data['content_id']);
        }

        return $book->fresh();
    }

    public function delete(int $id): bool
    {
        $book = Book::findOrFail($id);

        return $book->delete();
    }
}

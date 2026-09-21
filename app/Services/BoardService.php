<?php

namespace App\Services;

use App\Models\Board;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class BoardService
{
    public function all(): Collection
    {
        return Board::latest()->get();
    }

    public function paginate(int $perPage = 10, ?string $search = null): LengthAwarePaginator
    {
        $query = Board::latest();

        if ($search) {
            $query->where('board_name', 'like', "%{$search}%");
        }

        return $query->paginate($perPage)->withQueryString();
    }

    public function find(int $id): Board
    {
        return Board::findOrFail($id);
    }

    public function create(array $data): Board
    {
        return Board::create($data);
    }

    public function update(int $id, array $data): Board
    {
        $board = Board::findOrFail($id);
        $board->update($data);

        return $board->fresh();
    }

    public function delete(int $id): bool
    {
        $board = Board::findOrFail($id);

        return $board->delete();
    }
}

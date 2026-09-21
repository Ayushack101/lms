<?php

namespace App\Http\Controllers;

use App\Http\Requests\Board\StoreBoardRequest;
use App\Http\Requests\Board\UpdateBoardRequest;
use App\Http\Resources\BoardResource;
use App\Services\BoardService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BoardController extends Controller
{
    public function __construct(private BoardService $boardService)
    {
    }
    public function index(Request $request): View|Response
    {
        $boards = $this->boardService->paginate(10, $request->search);

        if ($request->ajax()) {
            return response()->view('pages.admin.boards.partials.board-rows', [
                'boards' => $boards,
            ]);
        }

        return view('pages.admin.boards.index', [
            'boards' => $boards,
        ]);
    }

    public function create(): View
    {
        return view('pages.admin.boards.create');
    }

    public function store(StoreBoardRequest $request): RedirectResponse
    {
        $this->boardService->create($request->validated());

        return redirect()->back()->with('success', 'Board created successfully.');
    }

    public function edit(int $id): View
    {
        $board = $this->boardService->find($id);

        return View('pages.admin.boards.edit', [
            'board' => $board,
        ]);
    }

    public function update(UpdateBoardRequest $request, int $id): RedirectResponse
    {
        $this->boardService->update($id, $request->validated());

        return redirect()->back()->with('success', 'Board updated successfully.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->boardService->delete($id);

        return redirect()->back()->with('success', 'Board deleted successfully.');
    }

    // API Methods

    public function apiIndex()
    {
        $boards = $this->boardService->all();

        return BoardResource::collection($boards);
    }

}
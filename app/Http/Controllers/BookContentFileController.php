<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookContentFile\StoreBookContentFileRequest;
use App\Http\Requests\BookContentFile\UpdateBookContentFileRequest;
use App\Services\BoardService;
use App\Services\BookContentFileService;
use App\Services\BookContentUploadService;
use App\Services\BookService;
use App\Services\ContentService;
use App\Services\SubjectService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BookContentFileController extends Controller
{
    public function __construct(private BookContentFileService $bookContentFileService, private BookContentUploadService $bookContentUploadService, private ContentService $contentService, private BookService $bookService, private SubjectService $subjectService, private BoardService $boardService)
    {
    }

    public function allBookContent(): View
    {
        $contents = $this->contentService->all();

        return view('pages.admin.book-content-files.all-book-content', [
            'contents' => $contents,
        ]);
    }

    public function index(Request $request, int $content_id): View
    {
        $bookContentFiles = $this->bookContentFileService->paginate($content_id, 10, $request->search);
        $content = $this->contentService->find($content_id);

        return view('pages.admin.book-content-files.index', [
            'bookContentFiles' => $bookContentFiles,
            'content' => $content,
        ]);
    }

    public function create(int $id): View
    {
        $boards = $this->boardService->all();
        $content = $this->contentService->find($id);

        return view('pages.admin.book-content-files.create', [
            'boards' => $boards,
            'content' => $content,
        ]);
    }

    public function getSubjectsByBoard(int $board_id): JsonResponse
    {
        $subjects = $this->subjectService->getSubjectsByBoard($board_id);

        return response()->json([
            'subjects' => $subjects,
        ], 200);
    }

    public function getBooksBySubject(int $subject_id): JsonResponse
    {
        $books = $this->bookService->getBooksBySubject($subject_id);

        return response()->json([
            'books' => $books,
        ], 200);
    }

    public function store(StoreBookContentFileRequest $request): RedirectResponse
    {
        $content = $this->contentService->find($request->input('content_id'));
        $data = $this->bookContentUploadService->prepareData($request->validated(), $request, $content);
        $this->bookContentFileService->create($data);

        return redirect()->back()->with('success', 'Book content file created successfully.');
    }

    public function edit(int $id): View
    {
        $bookContentFile = $this->bookContentFileService->findWithSubjectAndBoard($id);
        $boards = $this->boardService->all();
        $content = $this->contentService->find($bookContentFile->content_id);

        return view('pages.admin.book-content-files.edit', [
            'bookContentFile' => $bookContentFile,
            'boards' => $boards,
            'content' => $content,
        ]);
    }

    public function update(UpdateBookContentFileRequest $request, int $id): RedirectResponse
    {
        $bookContentFile = $this->bookContentFileService->find($id);
        $data = $this->bookContentUploadService->prepareUpdateData($request->validated(), $request, $bookContentFile);

        $this->bookContentFileService->update($id, $data);

        return redirect()->back()->with('success', 'Book content file updated successfully.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->bookContentFileService->delete($id);

        return redirect()->back()->with('success', 'Book content file deleted successfully.');
    }
}
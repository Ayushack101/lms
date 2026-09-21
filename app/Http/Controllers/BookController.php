<?php

namespace App\Http\Controllers;

use App\Http\Requests\Book\StoreBookRequest;
use App\Http\Requests\Book\UpdateBookRequest;
use App\Http\Resources\BookResource;
use App\Services\BookService;
use App\Services\ClassesService;
use App\Services\ContentService;
use App\Services\SubjectService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function __construct(private BookService $bookService, private SubjectService $subjectService, private ClassesService $classService, private ContentService $contentService)
    {
    }

    public function index(Request $request): View
    {
        $books = $this->bookService->paginate(10, $request->search);

        return view('pages.admin.books.index', [
            'books' => $books,
        ]);
    }

    public function create(): View
    {
        $subjects = $this->subjectService->all();
        $classes = $this->classService->all();
        $contents = $this->contentService->all();

        return view('pages.admin.books.create', [
            'subjects' => $subjects,
            'classes' => $classes,
            'contents' => $contents,
        ]);
    }

    public function store(StoreBookRequest $request): RedirectResponse
    {
        $this->bookService->create($request->validated());

        return redirect()->back()->with('success', 'Book created successfully.');
    }

    public function edit(int $id): View
    {
        $subjects = $this->subjectService->all();
        $classes = $this->classService->all();
        $contents = $this->contentService->all();
        $book = $this->bookService->findWithContents($id);

        return view('pages.admin.books.edit', [
            'subjects' => $subjects,
            'classes' => $classes,
            'contents' => $contents,
            'book' => $book,
        ]);
    }

    public function update(UpdateBookRequest $request, int $id): RedirectResponse
    {
        $this->bookService->update($id, $request->validated());

        return redirect()->back()->with('success', 'Book updated successfully.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->bookService->delete($id);

        return redirect()->back()->with('success', 'Book deleted successfully.');
    }

    // API Methods

    public function apiIndex(int $subject_id)
    {
        $books = $this->bookService->getBooksBySubject($subject_id);

        return BookResource::collection($books);
    }
}

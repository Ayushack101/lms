<?php

namespace App\Services;

use App\Models\BookContentFile;
use App\Models\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Storage;

class BookContentUploadService
{
    public function prepareData(array $data, Request $request, Content $content): array
    {
        $rules = [];

        // Zip & Extracted File
        if ($content->content_name == 'E-book' || $content->content_name == 'Test Paper Generator') {
            $rules['file_path'] = 'nullable|string|max:255';
            $rules['extract_path'] = 'nullable|string|max:255';
        }
        // Zip
        else if ($content->content_name == 'Software Download Link') {
            $rules['file_path'] = 'required|string|max:255';
        }
        // Video
        else if ($content->content_name == 'Topic Animation') {
            $rules['file_path'] = 'required|string|max:255';
        }
        // PDF
        else {
            if ($request->file_path) {
                $rules['file_path'] = 'required|file|mimes:pdf|max:102400';
            } elseif ($request->file_path_text) {
                $rules['file_path_text'] = 'required|string|max:255';
            }
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $file_path = null;
        $extract_path = null;
        $entry_file = null;
        $file_type = null;
        $file_url = null;

        // Zip & Extracted File
        if ($content->content_name == 'E-book' || $content->content_name == 'Test Paper Generator') {
            $file_type = 'zip';
            $file_path = $request->input('file_path');
            $extract_path = $request->input('extract_path');
            $entry_file = 'index.html';
        }
        // Zip
        elseif ($content->content_name == 'Software Download Link') {
            $file_type = 'zip';
            $file_path = $request->input('file_path');
        }
        // Video
        elseif ($content->content_name == 'Topic Animation') {
            $file_type = 'video';
            $file_path = $request->input('file_path');
        }
        // PDF
        else {
            if ($request->hasFile('file_path')) {
                $file_type = 'pdf';
                $file_path = $request->file('file_path')->store('pdfs', 'public');
            } elseif ($request->file_path_text) {
                $file_type = 'pdf';
                $file_path = $request->file_path_text;
            }
        }

        $thumbnail_path = null;

        if ($request->hasFile('thumbnail')) {
            $thumbnail_path = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $data['file_type'] = $file_type;
        $data['file_path'] = $file_path;
        $data['extract_path'] = $extract_path;
        $data['entry_file'] = $entry_file;
        $data['file_url'] = $file_url;
        $data['thumbnail'] = $thumbnail_path;

        return $data;
    }

    public function prepareUpdateData(
        array $data,
        Request $request,
        BookContentFile $bookContentFile
    ): array {

        $content = $bookContentFile->content;

        $rules = [];

        // Zip & Extracted File
        if ($content->content_name == 'E-book' || $content->content_name == 'Test Paper Generator') {
            $rules['file_path'] = 'nullable|string|max:255';
            $rules['extract_path'] = 'nullable|string|max:255';
        }
        // Zip
        elseif ($content->content_name == 'Software Download Link') {
            $rules['file_path'] = 'required|string|max:255';
        }
        // Video
        elseif ($content->content_name == 'Topic Animation') {
            $rules['file_path'] = 'required|string|max:255';
        }
        // PDF
        else {
            if ($request->file_path) {
                $rules['file_path'] = 'required|file|mimes:pdf|max:102400';
            } elseif ($request->file_path_text) {
                $rules['file_path_text'] = 'required|string|max:255';
            }
        }


        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $filePath = $bookContentFile->file_path;
        $extractPath = $bookContentFile->extract_path;
        $entryFile = $bookContentFile->entry_file;
        $fileType = $bookContentFile->file_type;
        $fileUrl = $bookContentFile->file_url;

        // Zip & Extracted File
        if ($content->content_name == 'E-book' || $content->content_name == 'Test Paper Generator') {
            $fileType = 'zip';
            $filePath = $request->input('file_path');
            $extractPath = $request->input('extract_path');
            $entryFile = 'index.html';
        }
        // Zip
        elseif ($content->content_name == 'Software Download Link') {
            $fileType = 'zip';
            $filePath = $request->input('file_path');
        }
        // Video
        elseif ($content->content_name == 'Topic Animation') {
            $fileType = 'video';
            $filePath = $request->input('file_path');
        }
        // PDF
        else {
            if ($request->file('file_path')) {
                // Delete old uploaded pdf
                if ($bookContentFile->file_path && Storage::disk('public')->exists($bookContentFile->file_path)) {
                    Storage::disk('public')->delete($bookContentFile->file_path);
                }
                $fileType = 'pdf';
                $filePath = $request->file('file_path')->store('pdfs', 'public');
            } elseif ($request->file_path_text) {
                $fileType = 'pdf';
                $filePath = $request->file_path_text;
            }
        }

        $thumbnail = $bookContentFile->thumbnail;

        if ($request->hasFile('thumbnail')) {
            if ($bookContentFile->thumbnail && Storage::disk('public')->exists($bookContentFile->thumbnail)) {
                Storage::disk('public')->delete($bookContentFile->thumbnail);
            }
            $thumbnail = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $data['file_type'] = $fileType;
        $data['file_path'] = $filePath;
        $data['extract_path'] = $extractPath;
        $data['entry_file'] = $entryFile;
        $data['file_url'] = $fileUrl;
        $data['thumbnail'] = $thumbnail;

        return $data;
    }
}

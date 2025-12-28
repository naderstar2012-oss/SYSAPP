<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileController extends Controller
{
    /**
     * Upload a file to AWS S3 and record it in the database.
     */
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:10240', // 10MB Max
            'related_to' => 'required|string|max:50', // e.g., 'property', 'contract', 'expense'
            'related_id' => 'required|integer',
        ]);

        $uploadedFile = $request->file('file');
        $originalName = $uploadedFile->getClientOriginalName();
        $extension = $uploadedFile->getClientOriginalExtension();
        $mimeType = $uploadedFile->getClientMimeType();
        $size = $uploadedFile->getSize();

        // Generate a unique file name and path
        $path = $request->input('related_to') . '/' . $request->input('related_id');
        $fileName = Str::uuid() . '.' . $extension;
        $filePath = $path . '/' . $fileName;

        // Upload to S3
        $disk = Storage::disk('s3');
        $disk->put($filePath, file_get_contents($uploadedFile), 'public');
        $url = $disk->url($filePath);

        // Record in database
        $file = File::create([
            'user_id' => auth()->id(),
            'related_to' => $request->input('related_to'),
            'related_id' => $request->input('related_id'),
            'file_name' => $originalName,
            'file_path' => $filePath,
            'file_url' => $url,
            'mime_type' => $mimeType,
            'file_size' => $size,
        ]);

        return response()->json($file, 201);
    }

    /**
     * Get a file URL (or download it).
     */
    public function show(string $id)
    {
        $file = File::findOrFail($id);

        // Check if the file exists on S3
        if (!Storage::disk('s3')->exists($file->file_path)) {
            return response()->json(['error' => 'File not found on storage.'], 404);
        }

        // Return the public URL for direct access
        return response()->json(['url' => $file->file_url]);
    }

    /**
     * Delete a file from S3 and the database.
     */
    public function destroy(string $id)
    {
        $file = File::findOrFail($id);

        // Delete from S3
        Storage::disk('s3')->delete($file->file_path);

        // Delete from database
        $file->delete();

        return response()->json(null, 204);
    }
}

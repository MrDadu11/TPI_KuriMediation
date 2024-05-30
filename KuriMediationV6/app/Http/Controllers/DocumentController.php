<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    //

    /**
     * Function that upload file to the user's folder location
     * **/
    public function upload(Request $request, $meetingId)
    {
        // Validate the uploaded file
        $request->validate([
            'document' => 'required|mimes:pdf|max:2048',
        ]);

        // Create a folder for the meeting using the meeting's ID
        $folderPath = 'public/pdf/' . $meetingId;
        if (!Storage::exists($folderPath)) {
            Storage::makeDirectory($folderPath);
        }
        // Store the uploaded file within the meeting's folder
        if ($request->file('document')->isValid()) {

            $path = $request->file('document')->storeAs($folderPath, $request->file('document')->getClientOriginalName());

            return back()->with('success', 'File uploaded successfully!')->with('document', $path);
        }

        return back()->with('error', 'Failed to upload file.');
    }
}

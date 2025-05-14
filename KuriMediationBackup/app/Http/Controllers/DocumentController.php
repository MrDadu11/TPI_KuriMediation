<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class DocumentController extends Controller
{
    /**
     * 
     * Controller for PDF documents
     * 
     */

    /**
     * Function that upload file to the user's folder location
     * **/
    public function upload(Request $request, $meetingId)
    {
        // Validate the uploaded file
        $request->validate([
            'document' => 'required|mimes:pdf|max:2048',
        ]);

        // Create a folder for the meeting using the meeting's ID if it doesn't exist yet
        $folderPath = Auth::id(). "/" . $meetingId;
        if (!Storage::disk('pdf')->exists($folderPath)) {
            Storage::disk('pdf')->makeDirectory($folderPath);
        }
        // Check if the document is valid
        if ($request->file('document')->isValid()) {
            // Store the uploaded file within the meeting's folder
            $request->file('document')->storeAs($folderPath, $request->file('document')->getClientOriginalName(), 'pdf');
            // Insert the new document into the database   
            Document::create([
                'filename' => $request->file('document')->getClientOriginalName(),
                'meeting_id' => $meetingId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            // Redirect to the previous page
            return redirect()->back();
        }
        // Redirect to the previous page with an error
        return back()->with('error', 'Erreur de montage du fichier. Vérifiez que c\'est au format PDF.');
    }

    /**
     * Function that deletes the file from the directory and the database
     */
    public function destroy($meetingId, $fileName)
    {
        // Get the pdf's path
        $filePath = Auth::id() . '/' . $meetingId . '/' . $fileName;
    
        if (Storage::disk('pdf')->exists($filePath)) {
            Storage::disk('pdf')->delete($filePath);
            // Remove from the database
            Document::where('filename', $fileName)->where('meeting_id', $meetingId)->delete();
            return redirect()->back();
        }
    
        // If the file does not exist, redirect with an error
        return redirect()->back()->with('error', 'File not found.');
    }
    

    /**
     * Function that displays the pdf in the browser and make it downloadable
     */ 
    public function show($meetingId, $fileName)
    {
        // Get the pdf path
        $filePath = Auth::id() . '/' . $meetingId . '/' . $fileName;
    
        // Check if the file exists
        if (Storage::disk('pdf')->exists($filePath)) {
            // Get the path
            $path = Storage::disk('pdf')->path($filePath);
    
            // Return the file for download
            return response()->file($path);
        }
        // If the file does not exist, redirect with an error
        return redirect()->back()->with('error', 'File not found.');
    }
}

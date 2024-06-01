<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

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
        $folderPath = 'public/pdf/'. Auth::id(). "/" . $meetingId;
        if (!Storage::exists($folderPath)) {
            Storage::makeDirectory($folderPath);
        }
        // Store the uploaded file within the meeting's folder
        if ($request->file('document')->isValid()) {

            $request->file('document')->storeAs($folderPath, $request->file('document')->getClientOriginalName());
            Document::create([
                'filename' => $request->file('document')->getClientOriginalName(),
                'meeting_id' => $meetingId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return redirect()->back();
        }

        return back()->with('error', 'Erreur de montage du fichier. Vérifiez que c\'est au format PDF.');
    }

    public function destroy($meetingId, $fileName){
        
        // Get the pdf's path
        $filePath = 'pdf/'. Auth::id(). "/" . $meetingId . "/" . $fileName;

        Storage::disk('public')->delete($filePath);

        return redirect()->back();
    }

    // Function that displays the pdf and make it downloadable
    public function show($meetingId, $fileName){

        // Get the pdf path
        $filePath = 'pdf/'. Auth::id(). "/" . $meetingId . "/" . $fileName;
        
        // Get the absolute path
        $path = Storage::disk('public')->path($filePath);

        return response()->file($path);
    }
}

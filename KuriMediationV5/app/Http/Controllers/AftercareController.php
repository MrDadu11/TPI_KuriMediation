<?php

namespace App\Http\Controllers;

use App\Models\Aftercare;
use App\Models\Meeting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AftercareController extends Controller
{
    // Controller for aftercares

    
    public function show($meetingId){
        $meeting = Meeting::where('id', $meetingId)->first();


        return view('add_aftercare', [
            'currentMeeting' => $meeting
        ]);
    }

    // Function that creates a new meeting with its parameters
    public function store(Request $request, $meetingId){

        // dd($request, $meetingId);
        // Validates the data
        $validatedData = $request->validate([
            'description' => 'required|string|max:255',
            'schedule' => 'required|date',
            'duration' => 'required|integer',
            'decision' => 'required|string|max:255',
            'visitor' => 'required|string|max:255',
        ]);


        // dd($validatedData);

        // Inserts the validated data and creates the aftercare
        Aftercare::create([
            'description' => $validatedData['description'],
            'schedule' => $validatedData['schedule'],
            'visitor' => $validatedData['visitor'],
            'duration' => $validatedData['duration'],
            'decision' => $validatedData['decision'],
            'meeting_id' => $meetingId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Redirects to the meeting information page
        return redirect()->route('meeting.edit', $meetingId);
    }
    // Function that shows the editing page of a meeting
    public function edit($aftercareId){

            $currentAftercare = Aftercare::where('id', $aftercareId)->first();
            $currentMeeting = Meeting::where('id', $currentAftercare->meeting_id)->first();
            return view('edit_aftercare',[
                'currentAftercare' => $currentAftercare,
                'currentMeeting' => $currentMeeting,
            ]);
    }

    // Function that updates the values in an existent meeting
    public function update(Request $request, $aftercareId){

            $currentAftercare = Aftercare::where('id', $aftercareId)->first();
            $currentMeeting = Meeting::where('id', $currentAftercare->meeting_id)->first();

            // Validates the data
            $validatedData = $request->validate([
                'description' => 'required|string|max:255',
                'visitor' => 'required|string|max:255',
                'duration' => 'required|int',
                'decision' => 'required|string|max:255',
            ]);
            
            $currentAftercare->update($validatedData);
            
            

            // Redirects to the homepage
            return redirect()->route('meeting.edit', $currentMeeting->id);
    }



    // Function that deletes the chosen meeting based on its ID
    public function destroy($aftercareId){
        Aftercare::where('id', $aftercareId)->delete();
        return redirect()->back();
    }


}

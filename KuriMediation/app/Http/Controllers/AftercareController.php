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


        return view('aftercares.add_aftercare', [
            'currentMeeting' => $meeting
        ]);
    }

    // Function that creates a new meeting with its parameters
    public function store(Request $request, $meetingId){

        // Validate the data
        $validatedData = $request->validate([
            'description' => 'required|string|max:255',
            'schedule' => 'required|date',
            'duration' => 'required|integer',
            'decision' => 'required|string|max:255',
            'visitor' => 'required|string|max:255',
        ]);

        // Insert the validated data and create the aftercare
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

        // Redirect to the meeting information page
        return redirect()->route('meeting.edit', $meetingId);
    }
    // Function that shows the editing page of a meeting
    public function edit($aftercareId){

            $currentAftercare = Aftercare::where('id', $aftercareId)->first();
            $currentMeeting = Meeting::where('id', $currentAftercare->meeting_id)->first();
            return view('aftercares.edit_aftercare',[
                'currentAftercare' => $currentAftercare,
                'currentMeeting' => $currentMeeting,
            ]);
    }

    // Function that updates the values in an existent meeting
    public function update(Request $request, $aftercareId){

            $currentAftercare = Aftercare::where('id', $aftercareId)->first();
            $currentMeeting = Meeting::where('id', $currentAftercare->meeting_id)->first();

            // Validate the data
            $validatedData = $request->validate([
                'description' => 'required|string|max:255',
                'visitor' => 'required|string|max:255',
                'duration' => 'required|int',
                'decision' => 'required|string|max:255',
            ]);

            // Update the aftercare
            $currentAftercare->update($validatedData);
            
            

            // Redirect to the homepage
            return redirect()->route('meeting.edit', $currentMeeting->id);
    }



    // Function that deletes the chosen meeting based on its ID
    public function destroy($aftercareId){
        // Delete the aftercare
        Aftercare::where('id', $aftercareId)->delete();
        // Redirect back
        return redirect()->back();
    }


}

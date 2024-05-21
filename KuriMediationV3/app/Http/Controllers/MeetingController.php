<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class MeetingController extends Controller
{
    /**
    *   Display the meeting's main page
    */
    public function index($year = null){
        
        // Gets all types of meetings
        $types = Type::all();
        
        // Array of months
        $months = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];       
        
        // Gets only the year value from the schedule
        $years = Meeting::selectRaw('extract(year FROM schedule) AS year')
        ->distinct()
        ->orderBy('year', 'asc')
        ->get();
        
        // Checks if the year has been defined, if so, the user gets to the view with the data.
        if($year){
            return view('home', [
                'meetingsTotal' => $this->countUserAllMeetings($year), // Get the total of meetings the user has
                'currentUser' => Auth::user(),
                'userMeetings' => $this->getUserAllMeetings($year),
                'timeSpent' => $this->countUserTimespent($year),
                'types' => $types,
                'years' => $years,
                'months' => $months,
                'currentYear' => $year,
            ]);

        }
        // If $year is not assigned, the earliest year from the DB will be assigned to $year and then redirected to the page
        elseif(Meeting::where('user_id', Auth::id())->count() > 0){
            $year = Meeting::selectRaw('extract(year FROM schedule) AS year')
            ->distinct()
            ->orderBy('year', 'asc')
            ->first()->year;
            
            return redirect()->route('meeting.index', $year);

        }
        // Displaying if there are no meetings in the database
        else{
            return view('home', [
                'types' => $types,
                'years' => $years,
                'months' => $months,
                'meetingsTotal' => 0,
                'userMeetings' => 0,
                'timeSpent' => 0,
                'currentUser' => Auth::user(),
            ]);
        }
    }

    // Function that creates a new meeting with its parameters
    public function store(Request $request){

        // Validates the data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'schedule' => 'required|date',
            'type_id' => 'required|exists:types,id',
            'visitor' => 'required|string|max:255',
        ]);

        // Insert the validated data
        Meeting::create([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'schedule' => $validatedData['schedule'],
            'visitor' => $validatedData['visitor'],
            'duration' => 0,
            'decision' => '',
            'user_id' => Auth::id(),
            'type_id' => $validatedData['type_id'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Redirects to the homepage
        return redirect()->route('meeting.index');
    }

    // Function that shows the editing page of a meeting
    public function edit($meetingId){

        // Gets all types of meetings
        $types = Type::all();
        
        // Array of months
        $months = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];       
        
        $year = Meeting::selectRaw('extract(year FROM schedule) AS year')
        ->where('id', $meetingId)
        ->distinct()
        ->orderBy('year', 'asc')
        ->first();


        // Gets only the year value from the schedule
        $years = Meeting::selectRaw('extract(year FROM schedule) AS year')
        ->distinct()
        ->orderBy('year', 'asc')
        ->get();

        // Gets the current meeting being edited
        $currentMeeting = Meeting::where('id', $meetingId)->first();
        // Gets the type name of the meeting
        $currentMeetingType = Type::where('id', $currentMeeting->type_id)->first()->name;
            
            return view('edit-meeting', [
                'currentUser' => Auth::user(),
                'types' => $types,
                'years' => $years,
                'months' => $months,
                'currentYear' => $year,
                'currentMeeting' => $currentMeeting,
                'currentMeetingType' => $currentMeetingType,
            ]);
    }

    // Function that deletes the chosen meeting based on its ID
    public function destroy($meetingId){
        Meeting::where('id', $meetingId)->delete();
        return redirect()->route('meeting.index');
    }

    // Function that returns the total amount of meetings the user has for the chosen year
    public function countUserAllMeetings($year){
        $total = Meeting::where('user_id', Auth::id())->whereYear('schedule', $year)->get();
        return $total->count();
    }

    // Function that returns the total amount of time spent for meetings by the user based on the chosen year
    public function countUserTimespent($year){
        $total = 0;
        $durations = Meeting::select('duration')->where('user_id', Auth::id())->whereYear('schedule', $year)->get();
        foreach($durations as $duration){
            $total += $duration->duration;
        }
        return $total;
    }

    // Function that retrieves all meetings the user has for the chosen year
    public function getUserAllMeetings($year){
        // Gets all user meetings
        for($i = 0; $i < 12; $i++){
            $userMeetings[$i] = Meeting::where('user_id', Auth::id())
            ->whereYear('schedule', $year)
            ->whereMonth('schedule', $i+1)
            ->get();
        }
        return $userMeetings;
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use App\Models\Type;
use App\Models\Aftercare;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

/** 
 * 
 * Lieu: ETML - Vennes
 * Auteur: Chris Noah Matthew Suboonsan
 * Date: 17.05.2024
 * Description: Contrôleur de ressources pour les entretiens
 * 
 * **/




class MeetingController extends Controller
{

    public const MONTHS = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre']; 

    /**
    *   Display the meeting's main page
    */
    public function index($year = null){
        
        // Gets all types of meetings
        $types = Type::all();      
        
        // Gets only the year value from the schedule
        $years = Meeting::selectRaw('extract(year FROM schedule) AS year')
        ->where('user_id', Auth::id())
        ->distinct()
        ->orderBy('year', 'asc')
        ->get();

        
        // Checks if the year has been defined, if so, the user gets to the view with the data.
        if($year){
            return view('home', [
                'meetingsTotal' => $this->countUserAllMeetings($year), // Get the total of meetings the user has
                'currentUser' => Auth::user(),
                'userMeetings' => $this->getUserAllMeetings($year),
                'timeSpent' => $this->formatToHoursMins($this->countUserTimeSpent($year)),
                'avgTimeSpent' => $this->getAvgTimeSpent($this->countUserAllMeetings($year), $this->countUserTimeSpent($year)),
                'upcomingMeetings' => $this->countUpcomingMeetings($year),
                'types' => $types,
                'years' => $years,
                'months' => self::MONTHS,
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
                'months' => self::MONTHS,
                'meetingsTotal' => 0,
                'userMeetings' => 0,
                'upcomingMeetings' => 0,
                'avgTimeSpent' => 0,
                'timeSpent' => 0,
                'currentYear' => null,
                'currentUser' => Auth::user(),
            ]);
        }
    }

    // Function that creates a new meeting with its parameters
    public function store(Request $request){
        // Instanciate a new meeting
        $meeting = new Meeting();
        // Validate the data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'schedule' => 'required|date',
            'type_id' => 'required|exists:types,id',
            'visitor' => 'required|string|max:255',
        ]);
        // Define the missing data
        $validatedData['duration'] = 0;
        $validatedData['decision'] = '';
        $validatedData['user_id'] = Auth::id();

        // Inserts the validated data and creates the meeting
        $meeting->create($validatedData);
        
        // Redirect to the homepage
        return redirect()->route('meeting.index');
    }

    /**
     * Function that displays the information page about the meeting based on its id
     */
    public function show($meetingId){

        // Gets all types of meetings
        $types = Type::all();
        
        $aftercares = Aftercare::where('meeting_id', $meetingId)->orderBy('schedule', 'asc')->get();
        
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

        // Retrieves each PDF files by looking in the directory
        $filesPath = Auth::id(). "/" . $meetingId;
        $userFilesPaths = Storage::disk('pdf')->files($filesPath);
        $filesName = [];
        // Split the full path so it can retrieve only the file name
        foreach($userFilesPaths as $filePath){
            $filePath = mb_split("/", $filePath);
            array_push($filesName, end($filePath));
        }
        
        return view('meetings.show_meeting', [
                'types' => $types,
                'years' => $years,
                'months' => self::MONTHS,
                'currentYear' => $year,
                'userFiles' => $filesName,
                'currentMeeting' => $currentMeeting,
                'currentMeetingType' => $currentMeetingType,
                'userAftercares' => $aftercares,
        ]);
    }

    // Function that shows the editing page of a meeting
    public function edit($meetingId){

        // Gets all types of meetings
        $types = Type::all();
        
        $aftercares = Aftercare::where('meeting_id', $meetingId)->orderBy('schedule', 'asc')->get();
        
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

        // Retrieves each PDF files by looking in the directory
        $filesPath = Auth::id(). "/" . $meetingId;
        $userFilesPaths = Storage::disk('pdf')->files($filesPath);
        $filesName = [];
        // Split the full path so it can retrieve only the file name
        foreach($userFilesPaths as $filePath){
            $filePath = mb_split("/", $filePath);
            array_push($filesName, end($filePath));
        }
            
            return view('meetings/edit_meeting', [
                'types' => $types,
                'years' => $years,
                'months' => self::MONTHS,
                'currentYear' => $year,
                'userFiles' => $filesName,
                'currentMeeting' => $currentMeeting,
                'currentMeetingType' => $currentMeetingType,
                'userAftercares' => $aftercares,
            ]);
    }

    // Function that updates the values in an existent meeting
    public function update(Request $request, $meetingId){

            $meeting = Meeting::where('id', $meetingId)->first();
            // Validates the data
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string|max:255',
                'visitor' => 'required|string|max:255',
                'type_id' => 'required|exists:types,id',
                'duration' => 'required|int',
                'decision' => 'required|string|max:255',
            ]);
            
            $meeting->update($validatedData);
            
            // Redirects to the homepage
            return redirect()->route('meeting.index');
    }


    // Function that deletes the chosen meeting based on its ID
    public function destroy($meetingId){
        Meeting::where('id', $meetingId)->delete();
        return redirect()->route('meeting.index');
    }


    /**
     * Function that returns the total amount of meetings the user has for the chosen year
     *  */ 
    public function countUserAllMeetings($year){
        $total = Meeting::where('user_id', Auth::id())->whereYear('schedule', $year)->get();
        return $total->count();
    }

    /**
     *   Function that returns the total amount of time spent for meetings and its aftercares
     *   for the user based on the chosen year
     **/
    public function countUserTimeSpent($year){
        $total = 0; // Define the total
        $meetings = Meeting::where('user_id', Auth::id()) // Get all meetings by the year
                            ->whereYear('schedule', $year)
                            ->get(); 
        // Sum the values into $total
        foreach($meetings as $meeting){
            $total += $meeting->duration;
            $aftercares = Aftercare::where('meeting_id', $meeting->id)->get();
            foreach($aftercares as $aftercare){
                $total += $aftercare->duration;
            }
        }
        return $total;
    }

    /**
     *  Function that calcultates the number of meetings upcoming based on the current date
     *  */ 
    public function countUpcomingMeetings($year){
        $meetings = Meeting::where('user_id', Auth::id())->whereYear('schedule', $year)->get();
        $count = 0;
        foreach($meetings as $meeting){
            if($meeting->schedule > today()){
                $count++;
            }
        }
        return $count;
    }

    /**
     * Function that calculates the average time spent on meetings and its aftercares in a year
     */
    public function getAvgTimeSpent($totalMeeting, $timeSpentYear){

        $AvgTimeSpent = $timeSpentYear / $totalMeeting;
        return $this->formatToHoursMins($AvgTimeSpent);
    }

    /** Function that retrieves all meetings the user has for the chosen year.
     *  returns an array sorted by months
     **/ 
    public function getUserAllMeetings($year){
        // Gets all user meetings based on the year
        for($i = 0; $i < 12; $i++){
            $userMeetings[$i] = Meeting::where('user_id', Auth::id())
            ->whereYear('schedule', $year)
            ->whereMonth('schedule', $i+1)
            ->get();
        }
        return $userMeetings;
    }

    /**
     * Format a number to hours and minutes
     */
    public function formatToHoursMins($total){
        $hours = floor($total / 60); // Get the hour leaving the minutes
        $minutes = $total % 60; // Get the minutes from the hours
        
        return sprintf('%02dh%02dmin', $hours, $minutes);
    }
}

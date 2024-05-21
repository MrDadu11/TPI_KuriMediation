<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MeetingController extends Controller
{
    /**
    *   Display the meeting's main page
    */
    public function index($year = null){
        $types = Type::all();
        $userMeetings = Meeting::all();
        $userNbrMeetings = $this->countUserAllMeetings();
        // Verify if the user has budgets or not. Otherwise, the user will be redirected to a form.
        // if ( && $year === null) {
        //     // return redirect()->route('years.create', [
        //     // 'user' => Auth::user(),
        //     // 'years' => $years,
        //     // ]);
        // }

        return view('home', [
            'meetingsTotal' => $userNbrMeetings,
        ]);
        
    }

    public function store(Request $request){

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|text',
            'schedule' => 'required|date',
            'type_id' => 'required|exists:types,id',
        ]);

        DB::table('meetings')->insert([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'schedule' => $validatedData['date'],
            'user_id' => Auth::id(),
            'type_id' => $validatedData['type_id'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('meeting.index');
    }

    public function countUserAllMeetings(){
        
        $userMeetings = Meeting::where('user_id', Auth::id())->get();
        return count($userMeetings);
    }
}

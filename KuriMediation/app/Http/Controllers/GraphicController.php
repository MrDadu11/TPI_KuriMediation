<?php

namespace App\Http\Controllers;

use App\Charts\Charts;
use App\Models\Aftercare;
use App\Models\Meeting;
use App\Models\Type;

use Illuminate\Support\Facades\Auth;

class GraphicController extends Controller
{
    // Controller for charts in the graphics page

    // Constant for months's indexes
    public const MONTHS = [
        '01' => 'Janvier',
        '02' => 'Février',
        '03' => 'Mars',
        '04' => 'Avril',
        '05' => 'Mai',
        '06' => 'Juin',
        '07' => 'Juillet',
        '08' => 'Août',
        '09' => 'Septembre',
        '10' => 'Octobre',
        '11' => 'Novembre',
        '12' => 'Décembre'
    ];


    /**
     * Function that display the graphics page
     *  */     
    public function index($year = null){
        // Get all types of meetings
        $types = Type::all();
        // Get the years
        $years = Meeting::selectRaw('extract(year FROM schedule) AS year')
        ->distinct()
        ->orderBy('year', 'asc')
        ->get();

        // Check if the year has been defined, if so, the user gets to the view with the data.
        if($year){
            // Get user's meetings based on the year
            $meetings = Meeting::where('user_id', Auth::id())->whereYear('schedule', $year)->get();
            
            // Get values of meetings per MONTH
            foreach(self::MONTHS as $monthIndex => $month){
                $valPerMonth[$monthIndex] = 0;  // Sets the value to 0 in case there's no value
                foreach($meetings as $meeting){
                    // Get aftercares for the meeting
                    $aftercares = Aftercare::where('meeting_id', $meeting->id);
                    // Checks if the month in the loop matches the month in meetings
                    if($monthIndex == $meeting->schedule->format('m')){
                        $valPerMonth[$monthIndex] += $meeting->duration;
                        foreach($aftercares as $aftercare){
                            $valPerMonth[$monthIndex] += $aftercare->duration;
                        }
                    }
                }
            }
            // Get values of meetings per CATEGORY
            $totalTimeCat = 0;  // Total of time spent   
            $totalNbrMeetingCat = 0;    // Total of meetings
            foreach($types as $typeIndex => $type){
                $valPerCat[$typeIndex] = 0; // Value per category set to 0
                $nbrPerCat[$typeIndex] = 0; // Number of meetings per category
                $typesNames[$typeIndex] = $type->name; // Set the name of the type
                foreach ($meetings as $meeting){
                    $aftercares = Aftercare::where('meeting_id', $meeting->id);
                    // If the type matches with the meeting's type, the values are added
                    if($type->id == $meeting->type_id){
                        // Set the value in the array
                        $valPerCat[$typeIndex] += $meeting->duration;   
                        $nbrPerCat[$typeIndex] += 1;    
                        $totalTimeCat += $meeting->duration;
                        $totalNbrMeetingCat += 1;
                        foreach($aftercares as $aftercare){
                            $totalTimeCat += $aftercare->duration;
                            $totalNbrMeetingCat += 1;
                        }
                    }
                }
            }
            array_push($valPerCat, $totalTimeCat);  // Add the total into the array
            array_push($nbrPerCat, $totalNbrMeetingCat);    // Add the total into the array
            array_push($typesNames, 'Total');   // Add a Total label

            // Charts array that will contains all arrays
            $charts = [];

            // Create the first chart
            $chart1PerMonth = new Charts;
            $chart1PerMonth->labels(array_values(self::MONTHS));
            $chart1PerMonth->dataset('Somme du temps passé par mois (heures)','column',array_values($this->formatToHoursMinutes($valPerMonth)));
            $chart1PerMonth->displayAxes(true);
            $chart1PerMonth->labelsRotation(-25);
            
            // Create the second chart
            $chart1PerCategory = new Charts;
            $chart1PerCategory->labels(array_values($typesNames));
            // First dataset 
            $chart1PerCategory->dataset('Nombre de d\'entretiens passés par catégorie', 'column', array_values($nbrPerCat))->color('rgb(255, 0, 0)');

            // Second dataset
            $chart1PerCategory->dataset('Somme du temps passé par catégorie (heures)', 'line', array_values($this->formatToHoursMinutes($valPerCat)))->color('rgba(0, 0, 250, 1)');

            // Create the first chart for Mobile format
            $chart2PerMonth = new Charts;
            $chart2PerMonth->labels(array_values(self::MONTHS));
            $chart2PerMonth->dataset('Somme du temps passé par mois (heures)', 'bar', array_values($valPerMonth));

            // Create the second chart for Mobile format
            $chart2PerCategory = new Charts;
            $chart2PerCategory->labels(array_values($typesNames));
            // First dataset
            $chart2PerCategory->dataset('Nombre de d\'entretiens passés par catégorie', 'bar', array_values($nbrPerCat))->color('rgb(255, 0, 0)');
            // Second dataset
            $chart2PerCategory->dataset('Somme du temps passé par catégorie (heures)', 'line', array_values($this->formatToHoursMinutes($valPerCat)))->color('rgba(0, 0, 250, 1)');

            // Push all the charts into $charts
            array_push($charts, $chart1PerMonth, $chart1PerCategory, $chart2PerMonth, $chart2PerCategory);

            // Return the view
            return view('graphics', [
                'types' => $types,
                'years' => $years,
                'months' => self::MONTHS,
                'currentUser' => Auth::user(),
                'currentYear' => intval($year),
                'charts' => $charts,
                'chart1PerMonth' => $chart1PerMonth,
                'chart1PerCategory' => $chart1PerCategory,
                'chart2PerMonth' => $chart2PerMonth,
                'chart2PerCategory' => $chart2PerCategory,
                'meetingsTotal' => $this->countUserAllMeetings($year), // Get the total of meetings the user has
                'userMeetings' => $this->getUserAllMeetings($year),
                'timeSpent' => $this->formatToHoursMins($this->countUserTimeSpent($year)),
                'avgTimeSpent' => $this->getAvgTimeSpent($this->countUserAllMeetings($year), $this->countUserTimeSpent($year)),

            ]);
        }        
        // If $year is not assigned, the earliest year from the DB will be assigned to $year and then redirected to the page
        elseif(Meeting::where('user_id', Auth::id())->count() > 0){
            $year = Meeting::selectRaw('extract(year FROM schedule) AS year')
            ->distinct()
            ->orderBy('year', 'asc')
            ->first()->year;
            

            return redirect()->route('graphic.index', $year);
            
            
        }
        else{
            // Display if there are no meetings in the database
            return view('graphics', [
                'types' => $types,
                'years' => $years,
                'months' => self::MONTHS,
                'currentUser' => Auth::user(),
                'charts' => null,
                'chart1PerMonth' => null,
                'chart1PerCategory' => null,
                'chart2PerMonth' => null,
                'chart2PerCategory' => null,
            ]);
        }
    }
    
    public function formatToHoursMinutes($valArray) {
        $newValArray = []; // Initialize the new array
    
        foreach($valArray as $index => $value) {
            $hours = floor($value / 60); // Get the hours
            $minutes = ($value % 60) / 60; // Convert remaining minutes to a fraction of an hour
            $newValArray[$index] = $hours + $minutes; // Put the value inside the array
        }
        return $newValArray;    // returns the array
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

    public function formatToHoursMins($total){
        $hours = floor($total / 60); // Get the hour leaving the minutes
        $minutes = $total % 60; // Get the minutes from the hours
        
        return sprintf('%02dh%02dmin', $hours, $minutes);
    }
    
    
}

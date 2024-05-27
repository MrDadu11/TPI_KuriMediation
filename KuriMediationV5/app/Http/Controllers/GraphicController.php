<?php

namespace App\Http\Controllers;

use App\Charts\Graphics;
use ConsoleTVs\Charts\Classes\C3\Chart;
use Illuminate\Http\Request;
use App\Models\Meeting;
use App\Models\Type;
use App\Models\Aftercare;

use Illuminate\Support\Facades\Auth;

class GraphicController extends Controller
{
    // Controller for charts in the graphics page


    // Function that display the graphics page
    public function index($year = null){

        // Gets all types of meetings
        $types = Type::all();
        $months = [
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

        $years = Meeting::selectRaw('extract(year FROM schedule) AS year')
        ->distinct()
        ->orderBy('year', 'asc')
        ->get();



        // Checks if the year has been defined, if so, the user gets to the view with the data.
        if($year){

            $meetings = Meeting::where('user_id', Auth::id())->whereYear('schedule', $year)->get();
            
            // Get values for meetings per MONTH
            foreach($months as $monthIndex => $month){
                $valPerMonth[$monthIndex] = 0;
                foreach($meetings as $meeting){
                    // Checks if the month in the loop matches the month in meetings
                    if($monthIndex == $meeting->schedule->format('m')){
                        $valPerMonth[$monthIndex] += $meeting->duration;
                    }
                }
            }
            

            $chartCheeseMonthly = new Graphics;
            $chartCheeseMonthly->labels(array_values($months));
            $chartCheeseMonthly->dataset('Somme du temps passé par mois', 'bar', array_values($valPerMonth))->options([
                'backgroundColor' => '#e02f44',
            ]);

            $chartCheeseCategorized = new Graphics;
            $chartCheeseCategorized->labels(array_values($types));
            $chartCheeseCategorized->dataset('Somme du temps passé par catégorie');


            return view('graphics', [
                'types' => $types,
                'years' => $years,
                'months' => $months,
                'currentYear' => $year,
                'chartCheeseMonthly' => $chartCheeseMonthly,
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
        // Displaying if there are no meetings in the database
        else{
            return view('graphics', [
                'types' => $types,
                'years' => $years,
                'months' => $months,
            ]);
        }
    }
}

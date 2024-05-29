<?php

namespace App\Http\Controllers;

use App\Charts\ChartsHC;
use ConsoleTVs\Charts\Classes\C3\Chart;
use Illuminate\Http\Request;
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
    

    // Function that display the graphics page
    public function index($year = null){

        // Gets all types of meetings
        $types = Type::all();



        // Gets the years
        $years = Meeting::selectRaw('extract(year FROM schedule) AS year')
        ->distinct()
        ->orderBy('year', 'asc')
        ->get();

        // Checks if the year has been defined, if so, the user gets to the view with the data.
        if($year){
            // Gets user's meetings based on the year
            $meetings = Meeting::where('user_id', Auth::id())->whereYear('schedule', $year)->get();
            
            // Get values of meetings per MONTH
            foreach(self::MONTHS as $monthIndex => $month){
                $valPerMonth[$monthIndex] = 0;
                foreach($meetings as $meeting){
                    // Checks if the month in the loop matches the month in meetings
                    if($monthIndex == $meeting->schedule->format('m')){
                        $valPerMonth[$monthIndex] += $meeting->duration;
                    }
                }
            }
            // Get values of meetings per CATEGORY
            foreach($types as $typeIndex => $type){
                $valPerCat[$typeIndex] = 0;
                $typesNames[$typeIndex] = $type->name;
                foreach ($meetings as $meeting){
                    if($typeIndex == $meeting->type_id){
                        $valPerCat[$typeIndex] += $meeting->duration;
                    }
                }
            }

            $chart1PerMonth = new ChartsHC;
            $chart1PerMonth->labels(array_values(self::MONTHS));
            $chart1PerMonth->dataset('Somme du temps passé par mois', 'column', array_values($valPerMonth))->options([
                'responsive' => true,
            ]);

            $chart1PerCategory = new ChartsHC;
            $chart1PerCategory->labels(array_values($typesNames));
            $chart1PerCategory->dataset('Somme du temps passé par catégorie', 'column', array_values($valPerCat))->options([
                'responsive' => true,
            ]);

            $chart2PerMonth = new ChartsHC;
            $chart2PerMonth->labels(array_values(self::MONTHS));
            $chart2PerMonth->dataset('Somme du temps passé par mois', 'bar', array_values($valPerMonth))->options([
                'responsive' => true,
            ]);

            $chart2PerCategory = new ChartsHC;
            $chart2PerCategory->labels(array_values($typesNames));
            $chart2PerCategory->dataset('Somme du temps passé par catégorie', 'bar', array_values($valPerCat))->options([
                'responsive' => true,
            ]);


            return view('graphics', [
                'types' => $types,
                'years' => $years,
                'months' => self::MONTHS,
                'currentYear' => $year,
                'chart1PerMonth' => $chart1PerMonth,
                'chart1PerCategory' => $chart1PerCategory,
                'chart2PerMonth' => $chart2PerMonth,
                'chart2PerCategory' => $chart2PerCategory,
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
                'months' => self::MONTHS,
            ]);
        }
    }
}

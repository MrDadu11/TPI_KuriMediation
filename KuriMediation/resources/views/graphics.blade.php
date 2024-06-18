<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>Graphiques</title>
</head>
<body>
    <header class="print hidden">
        <div class="flex justify-between text-xs">
            <div>ETML-Médiateur</div>
            <div class="font-extrabold">{{ $currentYear }}</div>
            <div><?php echo $currentUser->firstname . " " . $currentUser->lastname ?></div>
        </div>
    </header>
    <x-app-layout>
        <div class="bg-white md:shadow-2xl border md:mt-10 max-w-full md:max-w-7xl mx-auto px-4 py-2 md:px-5 xl:px-7 rounded-xl">
            <div class="px-3 py-6">
                @if ($charts !== null)
                    <div class="bg-white inline-flex border rounded-md hover:border-transparent mb-3">
                        {{-- Selector for the year --}}
                        <select onchange="location = this.value;" class="rounded-lg border-gray-300 shadow-md print-hide">
                            @foreach ($years as $year)
                                <option value="{{ route('graphic.index', $year->year) }}" {{ $currentYear == $year->year ? 'selected' : '' }}>
                                    {{ $year->year }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    {{-- Meetings Stats --}}
                    <div class="flex flex-col sm:flex-row justify-between space-y-2 sm:space-y-0 md:mb-4">
                        <div class="p-5 xl:mr-4 bg-white border border-gray-300 shadow-lg rounded-md w-full">
                            <h1 class="font-bold text-base md:text-xl text-blue-800">Nombre d'entretiens au total</h1>
                            <span class="font-semibold text-xl md:text-5xl">{{ $meetingsTotal }}</span>
                        </div>
                        <div class="p-5 xl:mx-4 bg-white border border-gray-300 shadow-lg rounded-md w-full">
                            <h1 class="font-bold text-base md:text-xl text-blue-800">Heures passés durant l'année</h1>
                            <span class="font-semibold text-xl md:text-5xl">{{ $timeSpent }}</span>
                        </div>
                        <div class="p-5 xl:ml-4 bg-white border border-gray-300 shadow-lg rounded-md w-full">
                            <h1 class="font-bold text-base md:text-xl text-blue-800">Moyenne d'heures par entretien</h1>
                            <span class="font-semibold text-xl md:text-5xl">{{ $avgTimeSpent }}</span>
                        </div>
                    </div>
                    <section class="space-y-3">
                        @if ($chart1PerMonth != null)
                        <div class="border border-gray-300 shadow-lg rounded-md p-1 xl:p-6 print hidden md:block">
                            {!! $chart1PerMonth->container() !!}                            
                        </div>
                        @endif
                        @if ($chart1PerCategory != null)
                        <div class="border border-gray-300 shadow-lg rounded-md p-1 xl:p-6 print hidden md:block">
                            {!! $chart1PerCategory->container() !!}                            
                        </div>
                        @endif
                        {{-- Displays for mobile --}}
                        @if ($chart2PerMonth != null)
                        <div class="border border-gray-300 shadow-lg rounded-md p-1 xl:p-6 print-hide md:hidden">
                            {!! $chart2PerMonth->container() !!}                            
                        </div>
                        @endif
                        @if ($chart2PerCategory != null)
                        <div class="border border-gray-300 shadow-lg rounded-md p-1 xl:p-6 print-hide md:hidden">
                            {!! $chart2PerCategory->container() !!}                            
                        </div>
                        @endif
                        <div class="flex justify-end">
                            <button class="px-2 py-1 border shadow-md bg-blue-800 text-white rounded-lg hover:bg-blue-600 trasnition ease-in-out duration-150 print-hide" onclick="exportToPDF()">Exporter en PDF</button>
                        </div>
                    </section>
                @else
                    <div class="font-bold text-xl flex justify-between items-center flex-col xl:flex-row space-y-5 xl:space-y-0">
                        <div>Aucune donnée</div>
                        <div>
                            <a href="{{ route('meeting.index') }}" class="px-2 py-1 text-white border shadow-md bg-blue-800 rounded-xl hover:bg-blue-600 transition duration-150 ease-in-out ">Ajouter un entretien</a>
                        </div>
                    </div>
                @endif
            </div>                       
        </div>
    </x-app-layout>
    <footer class="print hidden text-xs">
        <?php echo "Date d'impression: " . date('d-m-Y') ?>
    </footer>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highcharts/6.0.6/highcharts.js" charset="utf-8"></script>
    @if ($chart1PerMonth != null)
    {!! $chart1PerMonth->script() !!}        
    @endif
    @if ($chart1PerCategory != null)
    {!! $chart1PerCategory->script() !!}
    @endif
    @if ($chart2PerMonth != null)
    {!! $chart2PerMonth->script() !!}
    @endif
    @if ($chart2PerCategory != null)
    {!! $chart2PerCategory->script() !!}
    @endif

    <script defer>
    // Function that toggles the printing pop-up
    function exportToPDF() {
        resizeCharts();
        // Delay printing to ensure charts are resized
        setTimeout(() => {
        // Initiate printing
        window.print();
        // After printing, resize charts back
        }, 500);
        setTimeout(() => {
        // After printing, resize charts back
        resizeChartsBack();
        }, 500);
    }

    // Function that resizes the charts to the desired dimensions
    function resizeCharts() {
        // Get references to the charts
        chart1PerMonth = Highcharts.charts[0];
        chart1PerCategory = Highcharts.charts[1];
        // Set the size
        chart1PerMonth.setSize(600, 380);
        chart1PerCategory.setSize(600, 380);
    }

    // Function to resize charts back
    function resizeChartsBack() {
        // Resize chart1PerMonth back to original size
        if (chart1PerMonth) {
            chart1PerMonth.setSize(null, null, false);
        }
        // Resize chart1PerCategory back to original size
        if (chart1PerCategory) {
            chart1PerCategory.setSize(null, null, false);
        }
    }
    </script>
    <style>
        /* When the printing is prompted, it changes each class value to be displayed or not. */
        @media print {
            .print {
                display: block;
            }
            .print-hide {
                display: none;
            }
            .print-chart {
                display: flex;
                justify-content: center;
                align-content: center;
                margin-bottom: 0;
                margin-top: 0;
            }
            nav{
                display: none;
            }
            .print-stats{
                display: flex;
                flex-direction: row;
            }
        }
    </style>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>KuriMediation - Graphiques</title>
</head>
<body>
    <x-app-layout>
        <div class="bg-white shadow-lt border md:mt-10 max-w-full md:max-w-7xl mx-auto px-4 py-2 md:px-5 xl:px-7 rounded-xl">
            <div class="p-3 sm:p-6">
                <div class="bg-white inline-flex border rounded-md hover:border-transparent">
                    {{-- Selector for the year --}}
                    <select onchange="location = this.value;" class="rounded-lg border-gray-300 shadow-md">
                        @foreach ($years as $year)
                            <option value="{{ route('graphic.index', $year->year) }}" {{ $currentYear == $year->year ? 'selected' : '' }}>
                                {{ $year->year }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <section class="space-y-3">
                    <div class="border border-gray-300 shadow-lg rounded-md p-1 xl:p-8 chart-container hidden md:block">
                        {!! $chart1PerMonth->container() !!}
                    </div>
                    <div class="border border-gray-300 shadow-lg rounded-md p-1 xl:p-8 chart-container hidden md:block">
                        {!! $chart1PerCategory->container() !!}
                    </div>
                    {{-- Displays for mobile --}}
                    <div class="border border-gray-300 shadow-lg rounded-md p-1 xl:p-8 print-hide md:hidden">
                        {!! $chart2PerMonth->container() !!}
                    </div>
                    <div class="border border-gray-300 shadow-lg rounded-md p-1 xl:p-8 print-hide md:hidden">
                        {!! $chart2PerCategory->container() !!}
                    </div>
                    <div class="flex justify-end">
                        <button onclick="exportToPDF()" class="px-2 py-1 border shadow-md bg-blue-800 text-white rounded-lg print-hide">Exporter en PDF</button>
                    </div>
                </section>
            </div>                             
        </div>
    </x-app-layout>
    {{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highcharts/6.0.6/highcharts.js" charset="utf-8"></script>
    {!! $chart1PerMonth->script() !!}
    {!! $chart1PerCategory->script() !!}
    {!! $chart2PerMonth->script() !!}
    {!! $chart2PerCategory->script() !!}
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

        // Resize chart1PerMonth
        if (chart1PerMonth) {
            chart1PerMonth.setSize(600, 400);
        }

        // Resize chart1PerCategory
        if (chart1PerCategory) {
            chart1PerCategory.setSize(600, 400);
        }
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
            .chart-container {
                display: block;
            }
            .print-hide {
                display: none;
            }
        }
    </style>
</body>
</html>

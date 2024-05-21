<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    @vite('resources/css/app.css')
    <title>Accueil</title>
    <style>
    .active-link {
        border: 2px solid black;
    }
    </style>
    @livewireStyles
</head>
<body>
    <x-app-layout>
        <div class="sm:py-12">
            <div class="bg-white shadow-lt border sm:mt-2 max-w-7xl mx-auto px-4 py-2 sm:px-5 lg:px-7 rounded-xl">
                <div class="p-3 sm:p-6">
                    <section>
                        <div class="flex mb-2">
                            {{-- Selector for the year --}}
                            <select onchange="location = this.value;" class="rounded-lg border-gray-300 shadow-md">
                                @foreach ($years as $year)
                                    <option value="{{ route('meeting.index', $year->year) }}" {{ $currentYear == $year->year ? 'selected' : '' }}>
                                        {{ $year->year }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        {{-- Meetings Stats --}}
                        <div class="flex flex-col sm:flex-row justify-between">
                            <div class="p-5 my-2 sm:mr-4 sm:my-0 bg-white border border-gray-300 shadow-lg rounded-md w-full">
                                <h1 class="font-bold text-xl text-blue-800">Nombre d'entretiens au total</h1>
                                <span class="font-semibold text-5xl">{{ $meetingsTotal }}</span>
                            </div>
                            <div class="p-5 my-2 sm:mx-4 sm:my-0 bg-white border border-gray-300 shadow-lg rounded-md w-full">
                                <h1 class="font-bold text-xl text-blue-800">Temps passés durant l'année</h1>
                                <span class="font-semibold text-5xl">{{ $timeSpent }}</span>
                            </div>
                            <div class="p-5 my-2 sm:ml-4 sm:my-0 bg-white border border-gray-300 shadow-lg rounded-md w-full">
                                <h1 class="font-bold text-xl text-blue-800">Entretiens à venir</h1>
                                <span class="font-semibold text-5xl">{{ $meetingsTotal }}</span>
                            </div>
                        </div>

                        {{-- Search bar for mobile --}}
                        <div class="sm:hidden flex justify-end mt-5">
                            <form action="" class="">
                                <input class="rounded-lg border border-slate-400" type="text" placeholder="Rechercher">
                            </form>
                        </div>

                        {{-- Meetings list with a search bar, a sorter, and a button for adding a new meeting --}}
                        <div class="flex flex-col p-4 mt-5 bg-white border border-gray-300 shadow-lg rounded-md">
                            <div class="flex justify-between border-b pb-2 border-black">
                                <h1 class="flex items-center font-bold text-lg text-blue-800">Entretiens</h1>
                                <div class="inline-flex">
                                    {{-- Search bar --}}
                                    <form action="" class="hidden sm:block">
                                        <input class="rounded-lg border border-slate-400" type="text" placeholder="Rechercher">
                                    </form>
                                    <div class="ml-3">
                                        <label for="order" class="hidden sm:inline-block text-blue-800 font-bold">Trier par</label>
                                        <select name="order" class="rounded-lg border border-slate-400">
                                            <option value="orderByDate">Date</option>
                                            <option value="orderByAlphabetic">Ordre alphabétique</option>
                                            <option value="orderByAlphabeticReverse">Ordre alphabétique inversé</option>
                                        </select>
                                    </div>
                                    <livewire:pages.meetings.create-meeting-form/>
                                </div>
                            </div>
                            <ul>
                                @if ($userMeetings)
                                    @for ($i = 0; $i < 12; $i++)
                                    <ul>
                                        <li class="px-2 py-2 border-b shadow-sm rounded-lg border-gray-300"><?=$months[$i]?></li>
                                        @foreach ($userMeetings[$i] as $meeting)
                                        <li class="flex justify-between px-4 py-2 border-b rounded-sm text-gray-500">
                                            <div>Nom: {{ $meeting->name }}</div>
                                            <div>Intervenants: {{$meeting->visitor }}</div>
                                            <div class="flex">
                                                <div class="mx-1"><a href="{{ route('meeting.edit', $meeting->id) }}"><i class="fa fa-edit"></i></a></div>
                                                <div class="mx-1"><a href="{{ route('meeting.destroy', $meeting->id) }}"><i class="fa fa-trash"></i></a></div>
                                            </div>
                                        </li>
                                        @endforeach                            
                                    </ul>
                                    @endfor
                                @else
                                    <li class="px-2 py-2 border-b rounded-sm">Aucune donnée</li>
                                @endif
                            </ul>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </x-app-layout>
    @livewireScripts
</body>
</html>

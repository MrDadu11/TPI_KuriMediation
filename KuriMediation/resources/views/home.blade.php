<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- Icons for edit and delete --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    @vite('resources/css/app.css')
    <title>Accueil</title>
    @livewireStyles
</head>
<body>
    <x-app-layout>
            <div class="shadow-xl shadow-gray-300 border md:mt-10 max-w-full md:max-w-7xl mx-auto px-4 py-2 md:px-5 xl:px-7 rounded-xl">
                <div class="p-3 md:p-6">
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
                        <div class="flex flex-col xl:flex-row justify-between space-y-2 xl:space-y-0">
                            <div class="p-5 xl:mr-4 bg-white border border-gray-300 shadow-lg rounded-md w-full">
                                <h1 class="font-bold text-xl text-blue-800">Nombre d'entretiens au total</h1>
                                <span class="font-semibold text-5xl">{{ $meetingsTotal }}</span>
                            </div>
                            <div class="p-5 xl:mx-4 bg-white border border-gray-300 shadow-lg rounded-md w-full">
                                <h1 class="font-bold text-xl text-blue-800">Heures passés durant l'année</h1>
                                <span class="font-semibold text-5xl">{{ $timeSpent }}</span>
                            </div>
                            <div class="p-5 xl:ml-4 bg-white border border-gray-300 shadow-lg rounded-md w-full">
                                <h1 class="font-bold text-xl text-blue-800">Moyenne d'heures par entretien</h1>
                                <span class="font-semibold text-5xl">{{ $avgTimeSpent }}</span>
                            </div>
                        </div>

                        {{-- Search bar for mobile --}}
                        <div class="md:hidden flex justify-end mt-5">
                            <form action="" class="">
                                <input class="rounded-lg border border-slate-400" type="text" placeholder="Rechercher">
                            </form>
                        </div>

                        {{-- Meetings list with a search bar, a sorter, and a button for adding a new meeting --}}
                        <div class="flex flex-col p-4 mt-5 bg-white border border-gray-300 shadow-lg rounded-md">
                            <div class="flex justify-between border-b pb-2 border-black">
                                <span class="flex items-center font-bold text-lg text-blue-800">Entretiens</span>
                                <div class="inline-flex">
                                    {{-- Search bar --}}
                                    <form action="" class="hidden md:block">
                                        <input class="rounded-lg border border-slate-400" type="text" placeholder="Rechercher">
                                    </form>
                                    <div class="ml-3">
                                        <label for="order" class="hidden md:inline-block text-blue-800 font-bold">Trier par</label>
                                        <select name="order" class="rounded-lg border border-slate-400">
                                            <option value="orderByDate">Date</option>
                                            <option value="orderByAlphabetic">A-Z</option>
                                            <option value="orderByAlphabeticReverse">Z-A</option>
                                        </select>
                                    </div>
                                    <livewire:pages.meetings.create-meeting-form
                                    :types="$types"
                                    />
                                </div>
                            </div>
                            <div class="md:max-h-96 overflow-auto  rounded-md p-1">
                                {{-- Checks if the users has meetings or not --}}
                                @if ($userMeetings !== 0)
                                    @for ($i = 0; $i < 12; $i++)
                                    <ul>
                                        <li class="px-2 py-2 border-b shadow-sm rounded-lg border-gray-300 font-extrabold"><?=$months[$i]?></li>
                                        @foreach ($userMeetings[$i] as $meeting)
                                        <li class="flex justify-between px-4 py-2 border-b rounded-sm text-gray-500">
                                            <div class="flex flex-col md:block md:space-x-8">
                                                <span>Nom: {{ $meeting->name }}</span>
                                                <span>Intervenants: {{ $meeting->visitor }}</span>
                                                <span>Description: {{ $meeting->description }}</span>
                                                @foreach ($types as $type)
                                                    @if ($type->id == $meeting->type_id)
                                                        <span>Type: {{ $type->name }}</span>   
                                                    @endif                                                    
                                                @endforeach
                                                <span>Date: {{ \Carbon\Carbon::parse($meeting->schedule)->format('d.m.Y') }}</span>
                                                {{-- If the duration and the decision are not set --}}
                                                @if ($meeting->duration == 0)
                                                    <span class="text-red-500">Manque d'informations</span>
                                                @endif
                                            </div>
                                            <div class="flex space-x-2 items-center">
                                                <span><a href="{{ route('meeting.show', $meeting->id) }}"><i class="fa fa-info-circle fa-lg" ></i></a></span>
                                                <span><a href="{{ route('meeting.edit', $meeting->id) }}"><i class="fa fa-edit fa-lg" ></i></a></span>
                                                <span>
                                                    <a href="{{ route('meeting.destroy', $meeting->id) }}"onclick="return confirm('Voulez-vous supprimer cet entretien?');">
                                                        <i class="fa fa-trash fa-lg"></i>
                                                    </a>
                                                </span>
                                            </div>
                                        </li>
                                        @endforeach                            
                                    </ul>
                                    @endfor
                                @else
                                    <li class="px-2 py-2 border-b rounded-sm">Aucune donnée</li>
                                @endif
                            </div>
                        </div>
                    </section>
                </div>
            </div>
    </x-app-layout>
    @livewireScripts
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    {{-- Icons for edit and delete --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Meeting</title>
    @livewireStyles
</head>
<body>
    <x-app-layout>
        <div class="bg-white shadow-lt border md:mt-10 max-w-full md:max-w-7xl mx-auto px-4 py-2 md:px-5 xl:px-10 xl:py-6 rounded-xl">
            <livewire:pages.meetings.edit-meeting-form 
            :currentMeeting="$currentMeeting" 
            :types="$types"
            :years="$years"
            :months="$months"
            :currentYear="$currentYear"
            :currentMeetingType="$currentMeetingType"
            />
            <section class="flex flex-col p-4 mt-5 bg-white border border-gray-300 shadow-lg rounded-md">  
                <header class="flex justify-between border-b pb-2 border-black">
                    <span class="flex items-center font-bold text-lg text-blue-800">Suivis</span>
                    <div class="inline-flex xl:space-x-3">
                        {{-- Search bar --}}
                        <form action="" class="hidden md:block">
                            <input class="rounded-lg border border-slate-400" type="text" placeholder="Rechercher">
                        </form>
                        <div class="xl:flex xl:items-center xl:space-x-1">
                            <label for="order" class="hidden xl:inline-block  text-blue-800 font-bold">Trier par</label>
                            <select name="order" class="rounded-lg border border-slate-400">
                                <option value="orderByDate">Date</option>
                                <option value="orderByAlphabetic">A-Z</option>
                                <option value="orderByAlphabeticReverse">Z-A</option>
                            </select>
                        </div>
                        
                        <a href="{{ route('aftercare.show', $currentMeeting->id) }}" class="ml-2 py-2 px-3 rounded-lg border text-white font-extrabold bg-blue-800 hover:bg-blue-600 transition ease-in-out duration-150">
                        +
                        </a>
                    </div>
                </header> 
                <div>
                    <div class="md:max-h-96 overflow-auto">
                        @if ($userAftercares)
                            <ul>
                                @foreach ($userAftercares as $userAftercare)
                                <li class="flex justify-between px-4 py-2 border-b rounded-sm text-gray-500">
                                    <div class="flex flex-col md:block md:space-x-8">
                                        <span>Nom: {{ $userAftercare->name }}</span>
                                        <span>Intervenants: {{ $userAftercare->visitor }}</span>
                                        <span>Description: {{ $userAftercare->description }}</span>
                                    </div>
                                    <div class="flex space-x-2 items-center">
                                        <span><a href="{{ route('aftercare.edit', $userAftercare->id) }}"><i class="fa fa-edit fa-lg" ></i></a></span>
                                        <span><a href="{{ route('aftercare.destroy', $userAftercare->id) }}"><i class="fa fa-trash fa-lg"></i></a></span>
                                    </div>
                                </li>         
                                @endforeach                                                  
                            </ul>
                        @else
                        <li class="px-2 py-2 border-b rounded-sm">Aucune donnée</li>
                        @endif                            
                    </div>
                </div>               
            </section>
        </div>
    </x-app-layout>
    @livewireScripts
</body>
</html>

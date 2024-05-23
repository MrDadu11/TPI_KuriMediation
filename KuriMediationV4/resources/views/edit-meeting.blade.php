<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>Meeting</title>
    <style>
    </style>
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
                    </div>
                </header>                
            </section>
            <section>

            </section>
        </div>
    </x-app-layout>
    @livewireScripts
</body>
</html>

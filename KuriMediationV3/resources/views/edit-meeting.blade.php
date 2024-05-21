<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>Meeting</title>
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
                    <header>
                        <div class="flex justify-between">
                            <div class="font-bold text-blue-800 text-2xl"><h1><?= $currentMeeting->name; ?></h1></div>
                            <div class="flex font-bold text-blue-800">
                                <div class="flex p-2 rounded-lg shadow-md border ">
                                    <h1 class="mr-1">Date :</h1>
                                    <p class="text-black"><?= $currentMeeting->schedule;?></p>
                                </div>
                                <div class="flex p-2 rounded-lg shadow-md border">
                                    <h1 class="mr-1">Type :</h1>
                                    <p class="text-black"><?= $currentMeetingType; ?></p>
                                </div>
                            </div>
                        </div>
                    </header>
                    <section>
                        
                    </section>
                </div>
            </div>
        </div>
    </x-app-layout>
    @livewireScripts
</body>
</html>

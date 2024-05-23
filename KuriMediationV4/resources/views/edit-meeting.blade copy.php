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
            <div class="bg-white shadow-lt border md:mt-10 max-w-full md:max-w-7xl mx-auto px-4 py-2 md:px-5 xl:px-7 rounded-xl">
                <div class="p-3 sm:p-6">
                    <header>
                        <div class="flex justify-between">
                            <div class="font-bold text-blue-800 text-2xl"><h1><?= $currentMeeting->name; ?></h1></div>
                            <div class="flex font-bold text-blue-800">
                                <div class="flex p-2 rounded-lg shadow-sm border ">
                                    <h1 class="mr-1">Date :</h1>
                                    <p class="text-black"><?= $currentMeeting->schedule;?></p>
                                </div>
                                <div class="flex p-2 rounded-lg shadow-sm border">
                                    <h1 class="mr-1">Type :</h1>
                                    <p class="text-black"><?= $currentMeetingType; ?></p>
                                </div>
                            </div>
                        </div>
                    </header>
                    <section class="border border-gray-300 rounded-lg p-5">
                        <h1 class="font-bold text-blue-800 text-lg">{{ __('Entretien') }}</h1>
                        <form action="">
                            <div class="mt-2 flex justify-between">
                                <div>
                                    <x-input-label for="visitor" :value="__('Intervenants')" />
                                    <textarea type="text" class="rounded-lg border-gray-300 resize-none" id="visitor" name="visitor" placeholder="Entrez le nom des intervenants"><?= $currentMeeting->visitor ?></textarea>
                                    <x-input-error class="mt-2" :messages="$errors->get('visitor')" />
                                </div>
                                <div class="flex space-x-2">
                                    <div>
                                        <x-input-label for="visitor" :value="__('Intervenants')" />
                                        <textarea type="text" class="rounded-lg border-gray-300 resize-none" id="visitor" name="visitor" placeholder="Entrez le nom des intervenants"><?= $currentMeeting->visitor ?></textarea>
                                        <x-input-error class="mt-2" :messages="$errors->get('visitor')" />
                                    </div>
                                    <div>
                                        <x-input-label for="visitor" :value="__('Documents')" />
                                        <ul class="border border-gray-300 p-4 flex flex-col items-center">
                                            @for ($i = 0; $i < 3; $i++)
                                                <li class="text-blue-800">
                                                    - File <?= $i ?>
                                                </li>
                                            @endfor
                                        </ul>
                                        <input type="file" name="file">
                                    </div>
                                </div>
                            </div> 
                        </form>           
                    </section>
                </div>
            </div>
    </x-app-layout>
    @livewireScripts
</body>
</html>

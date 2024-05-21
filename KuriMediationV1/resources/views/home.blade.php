<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>KuriBudget - Accueil</title>
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
                        {{-- Meetings Stats --}}
                        <div class="flex flex-col sm:flex-row justify-between">
                            <div class="p-5 my-2 sm:mr-4 sm:my-0 bg-white border border-gray-300 shadow-lg rounded-md w-full">
                                <h1 class="font-bold text-xl text-blue-800">Nombre d'entretiens au total</h1>
                                <span class="font-semibold text-5xl"><?php echo $meetingsTotal; ?></span>
                            </div>
                            <div class="p-5 my-2 sm:mx-4 sm:my-0 bg-white border border-gray-300 shadow-lg rounded-md w-full">
                                <h1 class="font-bold text-xl text-blue-800">Moyenne d'entretiens par mois</h1>
                                <span class="font-semibold text-5xl"><?php echo $meetingsTotal; ?></span>
                            </div>
                            <div class="p-5 my-2 sm:ml-4 sm:my-0 bg-white border border-gray-300 shadow-lg rounded-md w-full">
                                <h1 class="font-bold text-xl text-blue-800">Entretiens à venir</h1>
                                <span class="font-semibold text-5xl"><?php echo $meetingsTotal; ?></span>
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
                                @for ($i = 0; $i < 30; $i++)
                                    <li class="px-2 py-2 border-b rounded-sm">Entretien <?php echo $i; ?></li>
                                @endfor
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

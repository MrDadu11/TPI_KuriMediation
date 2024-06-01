
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    {{-- Icons for edit and delete --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Informations : {{ $currentMeeting->name }}</title>
</head>
<body>
    <x-app-layout>
        <div class="bg-white border md:mt-10 max-w-full md:max-w-7xl mx-auto px-4 py-2 md:px-5 xl:px-10 xl:py-6 rounded-xl">
            <section>
                <div class="px-5 py-3 border rounded-lg shadow-xl">
                    <div class="flex justify-between items-start flex-col xl:items-center  xl:flex-row">
                        <div>
                            <label class="text-xl text-blue-800 font-bold " for="name">Nom :</label>
                            <div class="rounded-lg border-gray-200 resize-none p-2" id="name" name="name">
                                {{ $currentMeeting->name }}
                            </div>
                        </div>
                        <div class="flex flex-col xl:flex-row xl:space-x-2 items-start xl:items-center">
                            <div class="space-x-2">
                                <span class="font-bold py-1 text-blue-800 text-lg">Date:</span>
                                <span class="py-2">{{ \Carbon\Carbon::parse($currentMeeting->schedule)->format('m.d.Y') }}</span>
                            </div>
                            <div class="flex">
                                <label for="type_id" class="font-bold xl:px-2 py-1 text-blue-800 text-lg">Type:</label>
                                <div class="rounded-lg border-gray-200 p-2" id="type_id" name="type_id">
                                    @foreach ($types as $type)
                                        @if ($currentMeeting->type_id == $type->id)
                                            {{ $type->name }}
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-2 flex flex-col xl:flex-row justify-between">
                        <div class="xl:w-1/2">
                            <div>
                                <x-input-label for="visitor" :value="__('Intervenants')" />
                                <div class="border rounded-lg border-gray-200 resize-none w-full p-2" id="visitor" name="visitor">
                                    {{ $currentMeeting->visitor }}
                                </div>
                            </div>
                            <div>
                                <x-input-label for="description" :value="__('Description')" />
                                <div class="border rounded-lg border-gray-200 resize-none w-full p-2" id="description" name="description">
                                    {{ $currentMeeting->description }}
                                </div>
                            </div>
                            <div>
                                <x-input-label for="decision" :value="__('Decision')" />
                                <div class="border rounded-lg border-gray-200 resize-none w-full p-2" id="decision" name="decision">
                                    @if (empty($currentMeeting->decision))
                                    Rien
                                    @else
                                    {{ $currentMeeting->decision }}                                            
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col w-full xl:flex-row xl:space-x-2 xl:w-2/5 xl:justify-between">
                            <div class="flex flex-col w-full xl:items-center xl:flex-row">
                                <x-input-label for="duration" :value="__('Durée:')" />
                                <div class="rounded-lg border-gray-200 resize-none xl:ml-2 p-2" id="duration" name="duration">
                                    {{ $currentMeeting->duration }}
                                </div>
                            </div>
                            <div class="flex justify-center items-center mt-2 xl:mt-0 xl:items-end xl:justify-end xl:w-1/2">
                                <a href="{{ route('meeting.edit', $currentMeeting->id) }}" class="rounded-lg px-3 py-1 bg-blue-800 text-white h-10 flex items-center">Modifier</a>
                            </div>
                        </div>
                    </div>
                    {{-- Form for uploading a file --}}
                    <ul class="rounded-lg border px-5 py-3 flex flex-col items-center w-full space-y-2 mt-3">
                        <li class="border text-blue-800 font-bold rounded-md px-1">Documents</li>
                        @foreach ($userFiles as $file)
                            <li>
                                <a href="{{ route('document.show', ["fileName" => $file, "meetingId" => $currentMeeting->id]) }}" class="hover:text-blue-800">{{ $file }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </section>            
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
                                        <span>Durée: {{ $userAftercare->duration }} mins</span>
                                    </div>
                                    <div class="flex space-x-2 items-center">
                                        <span><a href="{{ route('aftercare.edit', $userAftercare->id) }}"><i class="fa fa-edit fa-lg" ></i></a></span>
                                        <span><a href="{{ route('aftercare.destroy', $userAftercare->id) }}" onclick="return confirm('Voulez-vous supprimer ce suivi?');"><i class="fa fa-trash fa-lg"></i></a></span>
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
</body>
</html>

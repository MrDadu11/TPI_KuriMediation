<section>
    <div class="px-5 py-3 border rounded-lg shadow-xl">
        {{-- Form that updates the meeting's informations --}}
        <form action="{{ route('meeting.update', $currentMeeting->id) }}" method="POST">
            @csrf
            <div class="flex justify-between items-start flex-col xl:items-center  xl:flex-row">
                <div>
                    <label class="text-xl text-blue-800 font-bold " for="name">Nom :</label>
                    <x-text-input wire:model="currentMeeting.name" class="rounded-lg border-gray-200 resize-none" id="name" name="name" placeholder="Nom de l'entretien" :value="$currentMeeting->name" required/>
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>
                <div class="flex flex-col xl:flex-row xl:space-x-2 items-start xl:items-center">
                    <div class="space-x-2">
                        <span class="font-bold py-1 text-blue-800 text-lg">Date:</span>
                        <span class="py-2">{{ \Carbon\Carbon::parse($currentMeeting->schedule)->format('m.d.Y') }}</span>
                    </div>
                    <div>
                        <label for="type_id" class="font-bold xl:px-3 py-1 text-blue-800 text-lg">Type:</label>
                        {{-- Displays every type available --}}
                        <select wire:model="currentMeeting.type_id" name="type_id" class="rounded-lg border border-gray-300" required>
                            @foreach ($types as $type)
                                <option value="{{ $type->id }}"{{ $currentMeeting->type_id == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('type_id')" />
                    </div>
                </div>
            </div>
            <div class="mt-2 flex flex-col xl:flex-row justify-between">
                <div class="xl:w-1/2">
                    <div>
                        <x-input-label for="visitor" :value="__('Intervenants')" />
                        <textarea wire:model="currentMeeting.visitor" class="rounded-lg border-gray-200 resize-none w-full" id="visitor" name="visitor" placeholder="Entrez le nom des intervenants" required>{{ $currentMeeting->visitor }}</textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('visitor')" />
                    </div>
                    <div>
                        <x-input-label for="description" :value="__('Description')" />
                        <textarea wire:model="currentMeeting.description" class="rounded-lg border-gray-200 resize-none w-full" id="description" name="description" placeholder="Entrez les données" required>{{ $currentMeeting->description }}</textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('description')" />
                    </div>
                    <div>
                        <x-input-label for="decision" :value="__('Decision')" />
                        <textarea wire:model="currentMeeting.decision" class="rounded-lg border-gray-200 resize-none w-full" id="decision" name="decision" placeholder="Entrez les données" required>{{ $currentMeeting->decision }}</textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('decision')" />
                    </div>
                </div>
                <div class="flex flex-col w-full xl:flex-row xl:space-x-2 xl:w-2/5 xl:justify-between">
                    <div class="flex flex-col w-full xl:items-center xl:flex-row">
                        <x-input-label for="duration" :value="__('Durée:')" />
                        <x-text-input wire:model="currentMeeting.duration" type="number" min="0" max="3600" class="rounded-lg border-gray-200 resize-none xl:ml-2" id="duration" name="duration" placeholder="0" :value="$currentMeeting->duration" required></x-text-input>
                        <x-input-error class="mt-2" :messages="$errors->get('duration')" />
                        </div>
                    <div class="flex justify-center items-center mt-2 xl:mb-2 xl:mt-0 xl:items-end xl:justify-end xl:w-1/2">
                        <button type="submit" class="rounded-lg px-3 py-1 bg-blue-800 text-white h-10 items-center">Sauvegarder</button>
                    </div>
                </div>
            </div>
        </form>
        {{-- Form for uploading a file --}}
        <form action="{{ route('document.upload', ['meetingId' => $currentMeeting->id]) }}" method="POST" enctype="multipart/form-data" class="mt-3">
            @csrf
            @method('POST')
            <ul class="rounded-lg border px-5 py-3 flex flex-col items-center w-full space-y-2">
                <li class="border text-blue-800 font-bold rounded-md px-1">Documents</li>
                @foreach ($userFiles as $file)
                    <li>
                        <a href="{{ route('document.show', ["fileName" => $file, "meetingId" => $currentMeeting->id]) }}">{{ $file }}</a>
                        {{-- Error message for document upload --}}
                        {{-- Link for deleting the document --}}
                        <a href="{{ route('document.destroy', ["fileName" => $file, "meetingId" => $currentMeeting->id]) }}" onclick="return confirm('Voulez-vous supprimer ce fichier?');"><i class="fa fa-trash fa-lg"></i></a>
                    </li>
                @endforeach
                <li><input type="file" name="document" id="document"></li>
                @error('document')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
                <li><button type="submit" class="rounded-lg px-3 py-1 bg-blue-800 text-white h-10 items-center mt-2">Ajouter un PDF</button></li>
            </ul>
        </form>
    </div>
</section>

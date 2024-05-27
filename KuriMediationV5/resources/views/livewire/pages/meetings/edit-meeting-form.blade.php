<section>
    <form action="{{ route('meeting.update', ['meetingId' => $currentMeeting->id ]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="px-5 py-3 border rounded-lg shadow-lg">
            <div class="flex justify-between items-center">
                <div>
                    <label class="text-xl text-blue-800 font-bold " for="name">Nom :</label>
                    <x-text-input wire:model="currentMeeting.name" class="rounded-lg border-gray-200 resize-none" id="name" name="name" placeholder="Nom de l'entretien" :value="$currentMeeting->name" required/>
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>
                <div class="flex flex-row xl:space-x-2 items-center">
                    <div class="space-x-2">
                        <span class="font-bold py-1 text-blue-800 text-lg">Date:</span>
                        <span class="py-2">{{ \Carbon\Carbon::parse($currentMeeting->schedule)->format('m.d.Y') }}</span>
                    </div>
                    <div>
                        <label for="type_id" class="font-bold px-3 py-1 text-blue-800 text-lg">Type:</label>
                        <select wire:model="currentMeeting.type_id" name="type_id" class="rounded-lg border border-gray-300" required>
                            @foreach ($types as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('type_id')" />
                    </div>
                </div>
            </div>
            <div class="mt-2 flex flex-col xl:flex-row justify-between">
                <div class="w-3/5">
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
                <div class="flex flex-col xl:flex-row xl:space-x-2">
                    <div class="flex flex-col justify-center items-center xl:flex-row xl:">
                        <x-input-label for="duration" :value="__('Durée:')" />
                        <x-text-input wire:model="currentMeeting.duration" type="number" class="rounded-lg border-gray-200 resize-none w-1/3 ml-2" id="duration" name="duration" placeholder="0" :value="$currentMeeting->duration" required></x-text-input>
                        <x-input-error class="mt-2" :messages="$errors->get('duration')" />
                    </div>
                    <div class="w-full xl:w-3/5 flex flex-col">
                        <ul class="rounded-lg border px-3 py-4 flex flex-col items-center w-full">
                            <li class="border text-blue-800 font-bold rounded-md px-1">Documents</li>
                            @for ($i = 0; $i < 3; $i++)

                            @endfor
                            <input type="file" wire:model="file" id="file" class="w-full" />
                        </ul>
                        <div class="flex justify-center items-center mt-2 xl:mt-0 xl:justify-end xl:items-end h-full">
                            <button type="submit" class="rounded-lg px-3 py-1 bg-blue-800 text-white w-1/2 h-10 items-center">Sauvegarder</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</section>

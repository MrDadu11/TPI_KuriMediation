<section>
    <form action="{{ route('meeting.update', $currentMeeting->id) }}" method="POST">
        @csrf
        @method('PUT')
        <header class="mb-2 font-bold text-blue-800 text-xl">{{ __('Nom: Entretien') }}</header>
        <div class="px-5 py-3 border rounded-lg shadow-md">
            <div class="flex justify-between">
                <div class="font-bold text-blue-800 text-lg rounded-lg">{{ __('Entretien') }}</div>
                <div>
                    <span class="font-bold px-3 py-1 text-blue-800 text-lg border rounded-lg">{{ __('Date: ') }} {{ $currentMeeting->schedule->format('d-m-Y') }}</span>
                    <span class="font-bold px-3 py-1 text-blue-800 text-lg border rounded-lg">{{ __('Type: ') }} {{ $currentMeetingType }}</span>
                </div>
            </div>
            <div class="mt-2 flex flex-col xl:flex-row justify-between">
                <div class="w-3/5">
                    <div>
                        <x-input-label for="visitor" :value="__('Intervenants')" />
                        <textarea wire:model="currentMeeting.visitor" class="rounded-lg border-gray-200 resize-none w-full" id="visitor" name="visitor" placeholder="Entrez le nom des intervenants">{{ $currentMeeting->visitor }}</textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('visitor')" />
                    </div>
                    <div>
                        <x-input-label for="description" :value="__('Description')" />
                        <textarea wire:model="currentMeeting.description" class="rounded-lg border-gray-200 resize-none w-full" id="description" name="description" placeholder="Entrez les données">{{ $currentMeeting->description }}</textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('description')" />
                    </div>
                    <div class="flex justify-between items-end">
                        <div>
                            <x-input-label for="decision" :value="__('Decision')" />
                            <textarea wire:model="currentMeeting.decision" class="rounded-lg border-gray-200 resize-none w-full" id="decision" name="decision" placeholder="Entrez les données">{{ $currentMeeting->decision }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('decision')" />
                        </div>
                    </div>
                </div>
                
                <div class="flex flex-col xl:flex-row xl:space-x-2">
                    <div>
                        <div class="flex flex-col xl:flex-row xl:items-center xl:justify-center">
                            <x-input-label for="duration" :value="__('Durée:')" />
                            <x-text-input wire:model="currentMeeting.duration" type="number" class="rounded-lg border-gray-200 resize-none w-1/3 ml-2" id="duration" name="duration" placeholder="0" value="{{ $currentMeeting->duration }}"></x-text-input>
                            <x-input-error class="mt-2" :messages="$errors->get('duration')" />
                        </div>
                    </div>
                    <div class="w-full xl:w-3/5 flex flex-col xl:flex-row">
                        <livewire:pages.meetings.add-document-form/>
                        <div class="flex justify-center items-center mt-2 xl:mt-0 xl:justify-end xl:items-end h-full">
                            <button type="submit" class="rounded-lg px-3 py-1 bg-blue-800 text-white w-1/2 h-10 items-center">Sauvegarder</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</section>

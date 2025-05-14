<?php

use App\Models\Type;
use App\Models\Meeting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;

new class extends Component
{
    public $userMeetings = [];
    public $types = [];
    public $months = [];

    public function mount(){
        $userMeetings = $this->userMeetings;
        $types = $this->types;
        $months = $this->months;
    }
    

}; ?>
<div class="md:max-h-96 overflow-auto  rounded-md p-1">
    {{-- Checks if the users has meetings or not --}}
    @if ($userMeetings !== 0)
        <ul>
            @for ($i = 0; $i < 12; $i++)
            <li class="px-2 py-2 border-b shadow-sm rounded-lg border-gray-300 font-extrabold">{{ $months[$i] }}</li>
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
            @endfor
        </ul>
    @else
        <li class="px-2 py-2 border-b rounded-sm">Aucune donnée</li>
    @endif
</div>

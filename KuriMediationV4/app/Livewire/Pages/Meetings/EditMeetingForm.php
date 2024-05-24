<?php

namespace App\Livewire\Pages\Meetings;

use Livewire\Component;

class EditMeetingForm extends Component
{
    public $currentMeeting;
    public $types;
    public $years;
    public $months;
    public $currentYear;
    public $currentMeetingType;

    public function mount($currentMeeting, $types, $years, $months, $currentYear, $currentMeetingType)
    {
        $this->currentMeeting = $currentMeeting;
        $this->types = $types;
        $this->years = $years;
        $this->months = $months;
        $this->currentYear = $currentYear;
        $this->currentMeetingType = $currentMeetingType;
    }

    

    public function render()
    {
        return view('livewire.pages.meetings.edit-meeting-form');
    }
}

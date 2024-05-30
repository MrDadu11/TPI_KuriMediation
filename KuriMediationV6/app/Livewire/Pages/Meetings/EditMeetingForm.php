<?php

namespace App\Livewire\Pages\Meetings;

use Livewire\Component;

class EditMeetingForm extends Component
{
    // Properties to hold various pieces of data passed to the component
    public $currentMeeting;        // Holds the current meeting data
    public $types;                 // Holds the different types of meetings
    public $years;                 // Holds the years data
    public $months;                // Holds the months data
    public $currentYear;           // Holds the current year
    public $currentMeetingType;    // Holds the current meeting type
    public $userFiles;             // Holds the user uploaded files


    // Function that mounts all the data to the livewire page
    public function mount($currentMeeting, $types, $years, $months, $currentYear, $currentMeetingType, $userFiles)
    {
        $this->currentMeeting = $currentMeeting;
        $this->types = $types;
        $this->years = $years;
        $this->months = $months;
        $this->currentYear = $currentYear;
        $this->currentMeetingType = $currentMeetingType;
        $this->userFiles = $userFiles;
    }

    

    public function render()
    {
        return view('livewire.pages.meetings.edit-meeting-form');
    }
}

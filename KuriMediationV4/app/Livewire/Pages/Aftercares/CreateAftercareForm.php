<?php

namespace App\Livewire\Pages\Aftercares;

use Livewire\Component;
use App\Models\Aftercare;

class CreateAftercareForm extends Component
{
    public $showForm = true;
    public $currentMeeting;

    public function toggleForm()
    {
        $this->showForm = !$this->showForm;
    }

    public function mount($currentMeeting){
        $this->currentMeeting = $currentMeeting;
    }

    public function create()
    {
        $validatedData = $this->validate([
            'aftercareData.schedule' => 'required|date',
            'aftercareData.duration' => 'required|integer',
            'aftercareData.visitor' => 'required|string|max:255',
            'aftercareData.description' => 'required|string',
            'aftercareData.decision' => 'required|string',
        ]);

        $aftercare = new Aftercare($validatedData['aftercareData']);
        $aftercare->meeting_id = $this->currentMeeting->id;
        $aftercare->save();

        $this->toggleForm(); // Close form after saving

        // Redirect to a different route after successful creation
        return redirect()->route('meeting.edit', $this->currentMeeting->id);
    }


    public function render()
    {
        return view('livewire.pages.aftercares.create-aftercare-form');
    }
}

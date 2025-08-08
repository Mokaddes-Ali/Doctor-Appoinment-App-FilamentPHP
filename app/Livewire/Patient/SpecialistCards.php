<?php

namespace App\Livewire\Patient;

use Livewire\Component;
use App\Models\Speciality;

class SpecialistCards extends Component
{
     public $specialist_cards;

    public function mount(){
        $this->specialist_cards = Speciality::where('status',1)
        ->orderBy('created_at', 'DESC')
        ->get();
    }
    public function render()
    {
        return view('livewire.patient.specialist-cards');
    }
}

<?php

namespace App\Livewire\Patient\Dashboard;

use App\Models\User;
use App\Models\Doctor;
use Livewire\Component;
use App\Models\Appoinment;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class LatestAppointment extends Component
{

    use WithPagination;
    public $perPage = 5;
    public $search = '';
    public $user;

    public function mount()
    {
        $this->user = Auth::user();
    }

    public function cancel($id)
    {
        $appointment = Appoinment::find($id);
        $patient = User::find($appointment->patient_id);
        $doctor = Doctor::find($appointment->doctor_id);

         $appointment->delete();
    }
    public function render()
    {
        return view('livewire.patient.dashboard.latest-appointment');
    }
}

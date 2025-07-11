<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class MonitoringAbsence extends Component
{
    public $search = '';
    
    public function render()
    {
        if(auth()->user()->role_id != 1){
            abort(403);
        }
        return view('livewire.monitoring-absence', ['users' => User::with('presensis')->where('name', 'like', '%'.$this->search.'%')->paginate(10)]);
    }
}

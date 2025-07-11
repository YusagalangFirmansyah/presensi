<?php

namespace App\Livewire;

use Livewire\Component;

class WelcomeDashboard extends Component
{
    public function render()
    {
        return view('livewire.welcome-dashboard', ['name' => auth()->user()->name]);
    }
}

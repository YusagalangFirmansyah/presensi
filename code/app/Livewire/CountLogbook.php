<?php

namespace App\Livewire;

use App\Models\Logbook;
use Livewire\Component;

class CountLogbook extends Component
{
    public function render()
    {
        return view('livewire.count-logbook', ['a' => Logbook::where('user_id', auth()->user()->id)->count()]);
    }
}

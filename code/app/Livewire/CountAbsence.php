<?php

namespace App\Livewire;

use App\Models\Absen;
use Livewire\Component;

class CountAbsence extends Component
{
    public function render()
    {
        return view('livewire.count-absence', ['a' => Absen::where('user_id', auth()->user()->id)->count()]);
    }
}

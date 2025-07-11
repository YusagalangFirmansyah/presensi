<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Presensi;

class CountPresence extends Component
{
    public function render()
    {
        return view('livewire.count-presence', ['a' => Presensi::where('user_id', auth()->user()->id)->count()]);
    }
}

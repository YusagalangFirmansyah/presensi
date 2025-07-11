<?php

namespace App\Livewire;

use App\Models\Absen;
use App\Models\Logbook;
use Livewire\Component;
use App\Models\Presensi;

class CountAdmin extends Component
{
    public function render()
    {
        return view('livewire.count-admin', ['a' => Absen::count(), 'b' => Presensi::count(), 'c' => Logbook::count()]);
    }
}

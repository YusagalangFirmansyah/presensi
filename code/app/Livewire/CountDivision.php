<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Division;

class CountDivision extends Component
{
    public function render()
    {
        return view('livewire.count-division', ['a' => Division::count()]);
    }
}

<?php

namespace App\Livewire;

use App\Models\Role;
use Livewire\Component;

class CountRole extends Component
{
    public function render()
    {
        return view('livewire.count-role', ['a' => Role::count()]);
    }
}

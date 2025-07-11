<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class CountGeneralUser extends Component
{
    public function render()
    {
        return view('livewire.count-general-user', ['a' => User::count()]);
    }
}

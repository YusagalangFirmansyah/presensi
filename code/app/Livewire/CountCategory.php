<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;

class CountCategory extends Component
{
    public function render()
    {
        return view('livewire.count-category', ['a' => Category::count()]);
    }
}

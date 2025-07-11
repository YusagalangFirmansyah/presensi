<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Division;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;

class DivisionsMenu extends Component
{
    use WithPagination, WithoutUrlPagination;
    protected $paginationTheme = 'bootstrap';
    
    public $isHome = true;
    public $isCreate = false;
    public $search = '';
    public $name;
    public $description;

    public function render()
    {
        if(auth()->user()->role_id != 1){
            abort(403);
        }
        return view('livewire.divisions-menu', ['divisions' => Division::where('name', 'like', '%'.$this->search.'%')->paginate(5)]);
    }

    public function back(){
        $this->isHome = true;
        $this->isCreate = false;
        $this->reset('name', 'description');
    }

    public function create(){
        $this->isHome = false;
        $this->isCreate = true;
    }

    public function store(){
        $this->validate([
            'name' => 'required|unique:divisions,name',
            'description' => 'nullable'
        ]);

        Division::create([
            'name' => $this->name,
            'description' => $this->description
        ]);

        $this->isHome = true;
        $this->isCreate = false;
        session()->flash('success', 'Division created successfully.');
        $this->back();
        $this->reset('name', 'description');
    }

    public function destroy($id){
        Division::destroy($id);
        session()->flash('success', 'Division deleted successfully.');
    }
}

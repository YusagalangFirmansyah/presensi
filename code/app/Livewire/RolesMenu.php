<?php

namespace App\Livewire;

use App\Models\Role;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;

class RolesMenu extends Component
{
    use WithPagination, WithoutUrlPagination;
    protected $paginationTheme = 'bootstrap';

    public $isHome = true;
    public $isCreate = false;
    public $isEdit = false;
    public $isShow = false;
    public $search = '';
    public $id;
    public $name;
    public $role;

    public function render()
    {
        if(auth()->user()->role_id != 1){
            abort(403);
        }
        return view('livewire.roles-menu', ['roles' => Role::where('name', 'like', '%'.$this->search.'%')->paginate(5)]);
    }

    public function back(){
        $this->isHome = true;
        $this->isCreate = false;
        $this->isEdit = false;
        $this->isShow = false;
        $this->reset('id', 'name', 'role');
    }

    public function create(){
        $this->isHome = false;
        $this->isCreate = true;
        $this->isEdit = false;
        $this->isShow = false;
    }

    public function store(){
        $this->validate([
            'name' => 'required|unique:roles,name'
        ]);

        Role::create([
            'name' => $this->name
        ]);

        $this->isHome = true;
        $this->isCreate = false;
        $this->isEdit = false;
        $this->isShow = false;
        session()->flash('success', 'User created successfully.');
        $this->back();
        $this->reset('id', 'name');
    }

    public function show($id){
        $this->isHome = false;
        $this->isCreate = false;
        $this->isEdit = false;
        $this->isShow = true;

        $this->role = Role::find($id);
    }

    public function destroy($id){
        Role::find($id)->delete();
        session()->flash('success', 'User deleted successfully.');
    }
}

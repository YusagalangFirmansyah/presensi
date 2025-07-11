<?php

namespace App\Livewire;

use App\Models\Role;
use App\Models\User;
use Livewire\Component;
use App\Models\Category;
use App\Models\Division;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;
use Illuminate\Support\Facades\Hash;

class UsersMenu extends Component
{
    use WithPagination, WithoutUrlPagination;
    protected $paginationTheme = 'bootstrap';

    public $isHome = true;
    public $isCreate = false;
    public $isEdit = false;
    public $isShow = false;
    public $search = '';
    public $id, $name, $email, $password, $role, $division, $category;
    public $roles, $divisions, $categories;

    public function render()
    {
        if(auth()->user()->role_id != 1){
            abort(403);
        }
        return view('livewire.users-menu', ['users' => User::with('role')->with('division')->with('category')->where('name', 'like', '%'.$this->search.'%')->paginate(5)]);
    }

    public function newuser(){
        $this->isHome = false;
        $this->isCreate = true;
        $this->isEdit = false;
        $this->isShow = false;
        $this->roles = Role::all();
        $this->categories = Category::all();
        $this->divisions = Division::all();
    }

    public function edit($id){
        $this->isHome = false;
        $this->isCreate = false;
        $this->isEdit = true;
        $this->isShow = false;
        $user = User::find($id);
        $this->id = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
    }

    public function show($id){
        $this->isHome = false;
        $this->isCreate = false;
        $this->isEdit = false;
        $this->isShow = true;
        $user = User::find($id);
        $this->id = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
    }

    public function back(){
        $this->isHome = true;
        $this->isCreate = false;
        $this->isEdit = false;
        $this->isShow = false;

        $this->reset('id', 'name', 'email', 'password', 'role', 'division', 'category', 'roles', 'divisions', 'categories');
    }

    public function save(){
        $this->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'role' => 'required|exists:roles,id',
            'division' => 'required|exists:divisions,id',
            'category' => 'required|exists:categories,id'
        ]);

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'role_id' => $this->role,
            'division_id' => $this->division,
            'category_id' => $this->category
        ]);

        // dd($user);

        session()->flash('success', 'User created successfully.');
        $this->reset('name', 'email', 'password', 'role', 'division', 'category');
        $this->back();
    }

    public function setUpdate($id){
        $this->validate([
            'name' => 'required',
            'email' => 'required|email'
        ]);

        $user = User::find($id);
        $user->update([
            'name' => $this->name,
            'email' => $this->email
        ]);

        session()->flash('success', 'User updated successfully.');
        $this->reset('name', 'email');
        $this->back();
    }

    public function destroy($id){
        User::find($id)->delete();
        session()->flash('success', 'User deleted successfully.');
        $this->back();
    }
}

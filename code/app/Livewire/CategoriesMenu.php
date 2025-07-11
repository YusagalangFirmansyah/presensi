<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;

class CategoriesMenu extends Component
{

    use WithPagination, WithoutUrlPagination;
    protected $paginationTheme = 'bootstrap';

    public $isHome = true;
    public $isCreate = false;
    public $isEdit = false;
    public $isShow = false;
    public $search = '';
    public $name, $description;

    public function render()
    {
        if(auth()->user()->role_id != 1){
            abort(403);
        }
        return view('livewire.categories-menu', ['categories' => Category::where('name', 'like', '%'.$this->search.'%')->paginate(5)]);
    }

    public function create(){
        $this->isHome = false;
        $this->isCreate = true;
        $this->isEdit = false;
        $this->isShow = false;
    }

    public function back(){
        $this->isHome = true;
        $this->isCreate = false;
        $this->isEdit = false;
        $this->isShow = false;
        $this->reset('name', 'description');
    }

    public function store(){
        // dd($this->category);
        $this->validate([
            'name' => 'required|unique:categories,name',
            'description' => 'nullable'
        ]);

        Category::create([
            'name' => $this->name,
            'description' => $this->description
        ]);

        $this->isHome = true;
        $this->isCreate = false;
        $this->isEdit = false;
        $this->isShow = false;
        session()->flash('success', 'Category created successfully.');
        $this->back();
        $this->reset('name', 'description');
    }

    public function destroy($id){
        Category::destroy($id);
        session()->flash('success', 'Category deleted successfully.');
    }
}

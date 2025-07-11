<?php

namespace App\Livewire;

use App\Models\Logbook;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;

class LogbookAdminMenu extends Component
{
    use WithPagination, WithoutUrlPagination;
    protected $paginationTheme = 'bootstrap';
    public $isHome = true;
    public $isDetail = false;
    public $logbook;

    public function render()
    {
        if(auth()->user()->role_id != 1){
            abort(403);
        }
        return view('livewire.logbook-admin-menu', ['logbooks' => Logbook::with('user')->orderBy('created_at', 'desc')->paginate(10)]);
    }

    public function home()
    {
        $this->isHome = true;
        $this->isDetail = false;
        $this->reset('logbook');
    }

    public function show($id){
        $this->isHome = false;
        $this->isDetail = true;
        $this->logbook = Logbook::with('user')->find($id);
        // dd($this->logbook);
    }
}

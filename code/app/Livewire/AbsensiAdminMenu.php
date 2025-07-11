<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Presensi;
use Jenssegers\Agent\Agent;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;

class AbsensiAdminMenu extends Component
{
    use WithPagination, WithoutUrlPagination;
    protected $paginationTheme = 'bootstrap';

    public $isHome = true;
    public $isDetail = false;
    public $info;

    public function render()
    {
        if(auth()->user()->role_id != 1){
            abort(403);
        }
        return view('livewire.absensi-admin-menu', ['presensis' => Presensi::with('user')->orderBy('created_at', 'desc')->paginate(10)]);
    }

    public function home()
    {
        $this->isHome = true;
        $this->isDetail = false;
        $this->reset('info');
    }

    public function detail($id)
    {
        $this->isHome = false;
        $this->isDetail = true;
        $this->info = Presensi::with('user')->where('id', $id)->first();
    }
}

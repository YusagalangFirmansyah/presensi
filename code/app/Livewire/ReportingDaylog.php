<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Absen;
use App\Models\Logbook;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;


class ReportingDaylog extends Component
{
    use WithPagination, WithoutUrlPagination;
    protected $paginationTheme = 'bootstrap';

    public $isHome = true;
    public $isUserDetail = false;
    public $search = '';
    public $alertAbsence = true;
    public $alertLogbook = true;
    public $detail;
    public $absences, $absen, $logbooks, $logbook;
    public $pengajuans;
    public $pengajuan;

    public function exportUserDetail($id)
    {
        return redirect()->action([\App\Http\Controllers\ReportingDaylogExportController::class, 'exportUserDetail'], ['id' => $id]);
    }

    public function render()
    {
        if(auth()->user()->role_id != 1){
            abort(403);
        }
        return view('livewire.reporting-daylog', ['users' => User::where('name', 'like', '%'.$this->search.'%')->paginate(10)]);
    }

    public function home(){
        $this->isHome = true;
        $this->isUserDetail = false;
        $this->reset('search', 'alertAbsence', 'detail', 'absences', 'absen', 'logbooks', 'alertLogbook', 'logbook');
    }

    public function userDetail($id){
        $this->isHome = false;
        $this->isUserDetail = true;
        $this->detail = User::with('division')->with('category')->find($id);
        $this->absences = Absen::with('absenHasPresensis')->where('user_id', $id)->orderBy('date', 'desc')->get();
        $this->logbooks = Logbook::where('user_id', $id)->orderBy('date', 'desc')->get();
        $this->pengajuans = \App\Models\Pengajuan::where('user_id', $id)->orderBy('created_at', 'desc')->get();
    }

    public function detailAbsence($id){
        $this->alertAbsence = false;
        $this->absen = Absen::with('absenHasPresensis.checkin')->with('absenHasPresensis.checkout')->find($id);
    }

    public function detailLogbook($id){
        $this->alertLogbook = false;
        $this->logbook = Logbook::find($id);
    }

    public function detailPengajuan($id){
        $this->pengajuan = \App\Models\Pengajuan::find($id);
    }
}

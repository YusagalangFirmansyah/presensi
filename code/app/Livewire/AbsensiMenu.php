<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\Absen;
use Livewire\Component;
use App\Models\Presensi;
use Jenssegers\Agent\Agent;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;

class AbsensiMenu extends Component
{
    use WithPagination, WithoutUrlPagination;
    protected $paginationTheme = 'bootstrap';
    
    public $alert = true;
    public $isHome = true;
    public $isIn = false;
    public $isOut = false;
    public $isDetail = false;
    public $status;
    public $plan;
    public $result;
    public $params;
    public $details;

    public function render()
    {
        // if (Absen::where('date', Carbon::now()->format('Y-m-d'))->where('user_id', auth()->user()->id)->exists() || Carbon::now()->format('l') == 'Sunday' || Carbon::now()->format('l') == 'Saturday') {
        //     $this->alert = false;
        // }else{
        //     $this->alert = true;
        // }

        return view('livewire.absensi-menu', ['absens' => Absen::with('absenHasPresensis')->where('user_id', auth()->user()->id )->paginate(10)]);
    }

    public function home(){
        $this->isHome = true;
        $this->isIn = false;
        $this->isOut = false;
        $this->isDetail = false;
        $this->reset('status', 'plan', 'result', 'params', 'details');
    }

    public function in(){
        $this->isHome = false;
        $this->isIn = true;
        $this->isOut = false;
        $this->isDetail = false;
    }

    public function out($outId){
        $this->isHome = false;
        $this->isIn = false;
        $this->isOut = true;
        $this->isDetail = false;
        $this->params = $outId;
    }

    public function storeIn(){
        $this->validate([
            'status' => 'required|in:1,2,3,4',
            'plan' => 'required'
        ]);

        $absen = Absen::create([
            'day' => Carbon::now()->format('l'),
            'date' => Carbon::now()->format('Y-m-d'),
            'user_id' => auth()->user()->id
        ]);

        $agent = new Agent();

        $presensi = Presensi::create([
            'category' => 1,
            'status' => $this->status,
            'description' => $this->plan,
            'device' => $agent->device(),
            'platform' => $agent->platform(),
            'platform_version' => $agent->version($agent->platform()),
            'browser' => $agent->browser(),
            'browser_version' => $agent->version($agent->browser()),
            'user_id' => auth()->user()->id
        ]);

        $absen->absenHasPresensis()->create([
            'checkin_id' => $presensi->id
        ]);

        session()->flash('success', 'Checkin Success! Welcome to Office!');
        $this->home();
    }

    public function storeOut(){
        $this->validate([
            'result' => 'required'
        ]);

        $agent = new Agent();

        $absen = Absen::find($this->params);

        $presensi = Presensi::create([
            'category' => 0,
            'status' => 0,
            'description' => $this->result,
            'device' => $agent->device(),
            'platform' => $agent->platform(),
            'platform_version' => $agent->version($agent->platform()),
            'browser' => $agent->browser(),
            'browser_version' => $agent->version($agent->browser()),
            'user_id' => auth()->user()->id
        ]);

        $absen->absenHasPresensis()->update([
            'checkout_id' => $presensi->id
        ]);

        session()->flash('success', 'Checkout Success! Have a nice day!');
        $this->home();
    }

    public function show($id){
        $this->isHome = false;
        $this->isIn = false;
        $this->isOut = false;
        $this->isDetail = true;
        $this->details = Absen::with('absenHasPresensis.checkin')->with('absenHasPresensis.checkout')->find($id);
        // dd($this->details);
    }
}

<?php

namespace App\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;

class LogbookMenu extends Component
{
    use WithPagination, WithoutUrlPagination;
    protected $paginationTheme = 'bootstrap';
    
    public $alert = true;
    public $isHome = true;
    public $isCreate = false;
    public $mood;
    public $activity;

    public function render()
    {
        if (auth()->user()->logbooks()->where('date', Carbon::now()->format('Y-m-d'))->where('user_id', auth()->user()->id)->exists() || Carbon::now()->format('l') == 'Sunday' || Carbon::now()->format('l') == 'Saturday') {
            $this->alert = false;
        }else{
            $this->alert = true;
        }

        return view('livewire.logbook-menu', ['logbooks' => auth()->user()->logbooks()->orderBy('date', 'desc')->paginate(10)]);
    }

    public function create()
    {
        $this->isHome = false;
        $this->isCreate = true;
    }

    public function home()
    {
        $this->isHome = true;
        $this->isCreate = false;
        $this->reset('mood', 'activity');
    }

    public function store(){
        $this->validate([
            'mood' => 'required',
            'activity' => 'required'
        ]);

        auth()->user()->logbooks()->create([
            'day' => Carbon::now()->format('l'),
            'date' => Carbon::now()->format('Y-m-d'),
            'time' => Carbon::now()->format('H:i:s'),
            'feeling' => $this->mood,
            'activity' => $this->activity,
        ]);

        session()->flash('success', 'Record Logbook successfully! 🎉');
        $this->home();
    }
}

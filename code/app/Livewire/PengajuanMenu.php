<?php

namespace App\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Pengajuan;

class PengajuanMenu extends Component
{
    use WithFileUploads;

    public $type = 'cuti';
    public $start_date, $end_date, $date;
    public $reason, $attachment;
    public $successMessage;

    public $isHome = true;
    public $isCreate = false;

    public function render()
    {
        $requests = auth()->user()->pengajuans()
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.pengajuan-menu', [
            'requests' => $requests
        ]);
    }

    public function create()
    {
        $this->resetErrorBag();
        $this->isCreate = true;
        $this->isHome = false;
    }

    public function home()
    {
        $this->resetExcept('isHome');
        $this->isHome = true;
        $this->isCreate = false;
    }

    public function store()
    {
        $user = auth()->user();

        // Cek role tidak diizinkan cuti
        if ($this->type === 'cuti' && in_array($user->role->name, config('cuti.disabled_roles'))) {
            $this->addError('type', 'Anda tidak dapat mengajukan cuti.');
            return;
        }

        // Cek limit cuti tahunan
        if ($this->type === 'cuti') {
            $currentYear = now()->year;
            $cutiCount = Pengajuan::where('user_id', $user->id)
                ->where('type', 'cuti')
                ->whereYear('created_at', $currentYear)
                ->whereIn('status', ['pending', 'approved'])
                ->count();

            if ($cutiCount >= config('cuti.max_per_year')) {
                $this->addError('type', 'Anda sudah mencapai batas maksimal cuti tahun ini.');
                return;
            }
        }

        // Validasi form
        $rules = [
            'type' => 'required|in:cuti,izin',
            'reason' => 'required|string',
            'attachment' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
        ];

        if ($this->type === 'cuti') {
            $rules['start_date'] = 'required|date';
            $rules['end_date'] = 'required|date|after_or_equal:start_date';
        } else {
            $rules['date'] = 'required|date';
        }

        $this->validate($rules);

        // Simpan attachment jika ada
        $path = $this->attachment ? $this->attachment->store('attachments', 'public') : null;

        // Simpan request
        $data = [
            'type' => $this->type,
            'reason' => $this->reason,
            'attachment' => $path,
        ];

        if ($this->type === 'cuti') {
            $data['start_date'] = $this->start_date;
            $data['end_date'] = $this->end_date;
        } else {
            $data['date'] = $this->date;
        }

        $user->pengajuans()->create($data);

        $this->successMessage = 'Pengajuan berhasil dikirim!';
        $this->home();
    }

    public function updatedType($value)
    {
        if ($value === 'cuti') {
            $this->date = null;
        } else {
            $this->start_date = null;
            $this->end_date = null;
        }
    }
}

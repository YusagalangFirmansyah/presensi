<?php

namespace App\Livewire;

use App\Models\Pengajuan;
use Livewire\Component;
use Livewire\WithPagination;

class PengajuanAdminMenu extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $isHome    = true;
    public $isDetail  = false;
    public $requestItem;

    protected $listeners = [
        'confirmApprove',
        'confirmReject',
    ];

    public function render()
    {
        // middleware admin
        if (auth()->user()->role_id !== 1) {
            abort(403);
        }

        $requests = Pengajuan::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.pengajuan-admin-menu', [
            'requests' => $requests,
        ]);
    }

    public function home()
    {
        $this->reset(['isDetail', 'requestItem']);
        $this->isHome = true;
    }

    public function show($id)
    {
        $this->requestItem = Pengajuan::with('user')->findOrFail($id);
        $this->isHome      = false;
        $this->isDetail    = true;
    }

    // dipanggil setelah user konfirmasi JS
    public function confirmApprove()
    {
        $this->updateStatus('approved');
    }

    public function confirmReject()
    {
        $this->updateStatus('rejected');
    }

    protected function updateStatus($status)
    {
        if (! $this->requestItem) {
            session()->flash('error', 'Data pengajuan tidak ditemukan.');
            return $this->home();
        }

        $this->requestItem->update(['status' => $status]);
        session()->flash('success', "Pengajuan telah di-{$status}.");
        $this->home();
    }
}

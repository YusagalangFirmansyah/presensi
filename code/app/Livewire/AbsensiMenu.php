<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\Absen;
use Livewire\Component;
use App\Models\Presensi;
use App\Models\Location; // <<< Tambahkan ini
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

    // <<< Tambahkan properti untuk latitude dan longitude
    public $userLatitude;
    public $userLongitude;
    // >>>

    public function render()
    {
        if (Absen::where('date', Carbon::now()->format('Y-m-d'))->where('user_id', auth()->user()->id)->exists() || Carbon::now()->format('l') == 'Sunday' || Carbon::now()->format('l') == 'Saturday') {
            $this->alert = false;
        }else{
            $this->alert = true;
        }

        return view('livewire.absensi-menu', ['absens' => Absen::with('absenHasPresensis')->where('user_id', auth()->user()->id )->paginate(10)]);
    }

    public function home(){
        $this->isHome = true;
        $this->isIn = false;
        $this->isOut = false;
        $this->isDetail = false;
        $this->reset('status', 'plan', 'result', 'params', 'details', 'userLatitude', 'userLongitude'); // <<< Reset juga koordinat
    }

    public function in(){
        $this->isHome = false;
        $this->isIn = true;
        $this->isOut = false;
        $this->isDetail = false;
        // <<< Dispatch event untuk meminta lokasi
        $this->dispatch('requestLocation');
    }

    public function out($outId){
        $this->isHome = false;
        $this->isIn = false;
        $this->isOut = true;
        $this->isDetail = false;
        $this->params = $outId;
        // <<< Dispatch event untuk meminta lokasi
        $this->dispatch('requestLocation');
    }

    // <<< Tambahkan metode untuk menerima lokasi dari frontend
    public function setLocation($latitude, $longitude)
    {
        $this->userLatitude = $latitude;
        $this->userLongitude = $longitude;
        // Setelah lokasi diterima, Anda bisa langsung memanggil storeIn/storeOut
        // Namun, jika ada validasi lain di form, biarkan user klik tombol submit
        // Atau Anda bisa langsung memanggil storeIn/storeOut dari sini setelah validasi form
    }
    // >>>

    public function storeIn(){
        $this->validate([
            'status' => 'required|in:1,2,3,4',
            'plan' => 'required',
            'userLatitude' => 'required|numeric', // <<< Tambahkan validasi lat/lon
            'userLongitude' => 'required|numeric', // <<< Tambahkan validasi lat/lon
        ]);

        // <<< Logika validasi jarak
        $officeLocation = Location::first(); // Ambil lokasi kantor (sesuaikan jika ada banyak lokasi)
        if (!$officeLocation) {
            session()->flash('error', 'Lokasi kantor tidak ditemukan dalam sistem.');
            $this->home();
            return;
        }

        $distance = $this->calculateDistance(
            $this->userLatitude,
            $this->userLongitude,
            $officeLocation->latitude,
            $officeLocation->longitude
        );

        if ($distance > $officeLocation->radius_km) {
            session()->flash('error', 'Anda berada di luar jangkauan lokasi kantor yang diizinkan! Jarak Anda: ' . round($distance * 1000, 2) . ' meter.');
            $this->home();
            return;
        }
        // >>>

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
            'latitude' => $this->userLatitude,   // <<< Simpan latitude
            'longitude' => $this->userLongitude, // <<< Simpan longitude
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
            'result' => 'required',
            'userLatitude' => 'required|numeric', // <<< Tambahkan validasi lat/lon
            'userLongitude' => 'required|numeric', // <<< Tambahkan validasi lat/lon
        ]);

        // <<< Logika validasi jarak (serupa dengan storeIn)
        $officeLocation = Location::first(); // Ambil lokasi kantor
        if (!$officeLocation) {
            session()->flash('error', 'Lokasi kantor tidak ditemukan dalam sistem.');
            $this->home();
            return;
        }

        $distance = $this->calculateDistance(
            $this->userLatitude,
            $this->userLongitude,
            $officeLocation->latitude,
            $officeLocation->longitude
        );

        if ($distance > $officeLocation->radius_km) {
            session()->flash('error', 'Anda berada di luar jangkauan lokasi kantor yang diizinkan untuk check-out! Jarak Anda: ' . round($distance * 1000, 2) . ' meter.');
            $this->home();
            return;
        }
        // >>>

        $agent = new Agent();

        $absen = Absen::find($this->params);

        $presensi = Presensi::create([
            'category' => 0,
            'status' => 0, // Anda mungkin perlu menyesuaikan status untuk checkout
            'description' => $this->result,
            'latitude' => $this->userLatitude,   // <<< Simpan latitude
            'longitude' => $this->userLongitude, // <<< Simpan longitude
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

    // <<< Tambahkan metode helper untuk menghitung jarak (Haversine Formula)
    private function calculateDistance($lat1, $lon1, $lat2, $lon2) {
        $earthRadius = 6371; // Radius bumi dalam kilometer

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $distance = $earthRadius * $c; // Jarak dalam KM

        return $distance;
    }
    // >>>
}
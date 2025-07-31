<div>
    {{-- ALERT SECTION: Tambahkan ini untuk menampilkan pesan sukses/error dari session flash --}}
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    {{-- AKHIR ALERT SECTION --}}

    @if ($isHome)
        <div class="section-header">
            <h1>Absence Menu</h1>
        </div>

        <div class="section-body">
            <h2 class="section-title">Absence List</h2>
            <p class="section-lead">In this section you can manage system Absence data such as adding, changing and deleting.</p>
            <div class="card">
                <div class="card-body">
                    @if ($alert)
                        <div class="alert alert-primary alert-has-icon">
                            <div class="alert-icon"><i class="fas fa-file-signature"></i></div>
                            <div class="alert-body">
                                <div class="alert-title">No Today Record</div>
                                You haven't checked in today. <br><br>
                                {{-- Tombol Check In: Akan memicu requestLocation --}}
                                <a wire:click.prevent="in()" href="#" class="btn btn-outline-light">Check In Now!</a>
                            </div>
                        </div>
                    @endif
                    {{-- Pesan sukses sudah ada, error sudah ditambahkan di awal --}}
                    {{-- @if (session()->has('success'))
                        <div class="alert alert-success alert-dismissible show fade">
                            <div class="alert-body">
                            <button class="close" data-dismiss="alert">
                                <span>×</span>
                            </button>
                            {{ session('success') }}
                            </div>
                        </div>
                        <br>
                    @endif --}}
                    <p><strong>Absences History</strong></p>
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Day</th>
                            <th scope="col">Date</th>
                            <th scope="col">Checked In</th>
                            <th scope="col">Checked Out</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($absens as $index => $a)
                                <tr>
                                    <th scope="row">{{$index +1}}</th>
                                    <td>{{$a->day}}</td>
                                    <td>{{$a->date}}</td>
                                    <td>
                                        @if ($a->absenHasPresensis[0]->checkin == null)
                                            <i class="fas fa-users"></i>
                                        @else
                                        <i class="fas fa-check-circle"></i>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($a->absenHasPresensis[0]->checkout == null)
                                            {{-- Tombol Check Out: Akan memicu requestLocation --}}
                                            <a wire:click.prevent="out({{$a->id}})" href="#" class="btn btn-icon btn-outline-danger"><i class="fas fa-sign-out-alt"></i></a>
                                        @else
                                        <i class="fas fa-check-circle"></i>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="buttons">
                                            <a wire:click.prevent="show({{$a->id}})" href="#" class="btn btn-icon btn-info"><i class="fas fa-info-circle"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @if (count($absens) === 0)
                            <tr>
                                <td colspan="6" class="text-center">No Data Found</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                    {{$absens->links()}}
                </div>
            </div>
        </div>
    @endif

    @if ($isIn)
        <div class="section-header">
            <h1>Check In Station</h1>
        </div>

        <div class="section-body">
            <h2 class="section-title">Check In Station</h2>
            <p class="section-lead">In this section you can check in.</p>
            <div class="card">
                <div class="card-body">
                    <p><strong>Check In Form!</strong></p>
                    <form wire:submit.prevent="storeIn">
                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" name="status" id="status" wire:model="status">
                                <option>Choose Status</option>
                                <option value="1">Hadir</option>
                                <option value="2">Izin</option>
                                <option value="3">Sakit</option>
                                <option value="4">Alpha</option>
                            </select>
                            @error('status') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="name">Today Plan</label>
                            <input type="text" class="form-control" id="name" wire:model="plan">
                            @error('plan') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        {{-- Hidden inputs untuk menyimpan lokasi --}}
                        <input type="hidden" wire:model="userLatitude">
                        <input type="hidden" wire:model="userLongitude">
                        {{-- End Hidden Inputs --}}

                        <a href="#" wire:click="home()" class="btn btn-primary">Back</a>
                        {{-- Tombol Save dengan indikator loading --}}
                        <button type="submit" class="btn btn-success" wire:loading.attr="disabled" wire:target="storeIn">
                            <span wire:loading wire:target="storeIn">Mendeteksi Lokasi...</span>
                            <span wire:loading.remove wire:target="storeIn">Save</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endif

    @if ($isOut)
        <div class="section-header">
            <h1>Check Out Station</h1>
        </div>

        <div class="section-body">
            <h2 class="section-title">Check Out Station</h2>
            <p class="section-lead">In this section you can check out.</p>
            <div class="card">
                <div class="card-body">
                    <p><strong>Check Out Form!</strong></p>
                    <form wire:submit.prevent="storeOut">
                        <div class="form-group">
                            <label for="name">Today Result</label>
                            <input type="text" class="form-control" id="name" wire:model="result">
                            @error('result') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        {{-- Hidden inputs untuk menyimpan lokasi --}}
                        <input type="hidden" wire:model="userLatitude">
                        <input type="hidden" wire:model="userLongitude">
                        {{-- End Hidden Inputs --}}

                        <a href="#" wire:click="home()" class="btn btn-primary">Back</a>
                        {{-- Tombol Save dengan indikator loading --}}
                        <button type="submit" class="btn btn-success" wire:loading.attr="disabled" wire:target="storeOut">
                            <span wire:loading wire:target="storeOut">Mendeteksi Lokasi...</span>
                            <span wire:loading.remove wire:target="storeOut">Save</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endif

    @if ($isDetail)
        <div class="section-header">
            <h1>Absence Information</h1>
        </div>

        <div class="section-body">
            <h2 class="section-title">Detail Information</h2>
            <p class="section-lead">In this section you can show detail of your absence information.</p>
            <div class="card">
                <div class="card-body">
                    <p><strong>General Information</strong></p>
                    <table class="table table-striped table-borderless">
                        <tr>
                            <th>Day</th>
                            <td>{{$details->day}}</td>
                        </tr>
                        <tr>
                            <th>Date</th>
                            <td>{{$details->date}}</td>
                        </tr>
                        <tr>
                            <th>Created At</th>
                            <td>{{$details->created_at}}</td>
                        </tr>
                        <tr>
                            <th>Updated At</th>
                            <td>{{$details->updated_at}}</td>
                        </tr>
                    </table>
                    <hr>
                    <div class="row">
                        <div class="col-6">
                            <p><strong>Check In Information</strong></p>
                            <table class="table table-striped table-borderless">
                                <tr>
                                    <th>Check In Time</th>
                                    <td>{{$details->absenHasPresensis[0]->checkin->created_at}}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        @if ($details->absenHasPresensis[0]->checkin->status == 1)
                                            <span class="badge badge-success">Hadir</span>
                                        @elseif($details->absenHasPresensis[0]->checkin->status == 2)
                                            <span class="badge badge-warning">Izin</span>
                                        @elseif($details->absenHasPresensis[0]->checkin->status == 3)
                                            <span class="badge badge-info">Sakit</span>
                                        @elseif($details->absenHasPresensis[0]->checkin->status == 4)
                                            <span class="badge badge-danger">Alpha</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Plan</th>
                                    <td>{{$details->absenHasPresensis[0]->checkin->description}}</td>
                                </tr>
                                <tr>
                                    <th>Device</th>
                                    <td>{{$details->absenHasPresensis[0]->checkin->device}}</td>
                                </tr>
                                <tr>
                                    <th>Platform / Version</th>
                                    <td>{{$details->absenHasPresensis[0]->checkin->platform}} / {{$details->absenHasPresensis[0]->checkin->platform_version}}</td>
                                </tr>
                                <tr>
                                    <th>Browser / Version</th>
                                    <td>{{$details->absenHasPresensis[0]->checkin->browser}} / {{$details->absenHasPresensis[0]->checkin->browser_version}}</td>
                                </tr>
                                {{-- Menampilkan lokasi Check In --}}
                                <tr>
                                    <th>Latitude (Check In)</th>
                                    <td>{{$details->absenHasPresensis[0]->checkin->latitude ?? 'N/A'}}</td>
                                </tr>
                                <tr>
                                    <th>Longitude (Check In)</th>
                                    <td>{{$details->absenHasPresensis[0]->checkin->longitude ?? 'N/A'}}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-6">
                            <p><strong>Check Out Information</strong></p>
                            @if ($details->absenHasPresensis[0]->checkout == null)
                                <div class="alert alert-warning">
                                    <div class="alert-title">Be Careful!</div>
                                    You haven't checked out yet..
                                </div>
                            @else
                                <table class="table table-striped table-borderless">
                                    <tr>
                                        <th>Check Out Time</th>
                                        <td>{{$details->absenHasPresensis[0]->checkout->created_at}}</td>
                                    </tr>
                                    <tr>
                                        <th>Result</th>
                                        <td>{{$details->absenHasPresensis[0]->checkout->description}}</td>
                                    </tr>
                                    <tr>
                                        <th>Device</th>
                                        <td>{{$details->absenHasPresensis[0]->checkout->device}}</td>
                                    </tr>
                                    <tr>
                                        <th>Platform / Version</th>
                                        <td>{{$details->absenHasPresensis[0]->checkout->platform}} / {{$details->absenHasPresensis[0]->checkout->platform_version}}</td>
                                    </tr>
                                    <tr>
                                        <th>Browser / Version</th>
                                        <td>{{$details->absenHasPresensis[0]->checkout->browser}} / {{$details->absenHasPresensis[0]->checkout->browser_version}}</td>
                                    </tr>
                                    {{-- Menampilkan lokasi Check Out --}}
                                    <tr>
                                        <th>Latitude (Check Out)</th>
                                        <td>{{$details->absenHasPresensis[0]->checkout->latitude ?? 'N/A'}}</td>
                                    </tr>
                                    <tr>
                                        <th>Longitude (Check Out)</th>
                                        <td>{{$details->absenHasPresensis[0]->checkout->longitude ?? 'N/A'}}</td>
                                    </tr>
                                </table>
                            @endif
                        </div>
                    </div>
                    <a href="#" wire:click="home()" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
    @endif
</div>

{{-- SCRIPT SECTION: Tambahkan ini di bagian bawah file blade Anda, atau di stack JS --}}
@push('scripts')
<script>
    // Pastikan Livewire sudah diinisialisasi sebelum mendengarkan event
    document.addEventListener('livewire:initialized', () => {
        // Mendengarkan event 'requestLocation' yang dipancarkan dari Livewire component
        @this.on('requestLocation', () => {
            if (navigator.geolocation) {
                // Mendapatkan posisi geografis saat ini
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        const userLat = position.coords.latitude;
                        const userLon = position.coords.longitude;
                        console.log('Location obtained:', userLat, userLon); // Untuk debugging
                        // Mengirim lokasi yang didapat ke properti Livewire component
                        @this.set('userLatitude', userLat);
                        @this.set('userLongitude', userLon);

                        // Setelah lokasi berhasil didapat dan diset ke Livewire,
                        // Anda dapat secara otomatis mensubmit form jika tidak ada validasi input lain.
                        // Jika ada validasi form lain (seperti status/plan), biarkan user klik tombol Save.
                        // Untuk kasus ini, karena Anda menggunakan wire:submit.prevent,
                        // data lokasi akan otomatis terkirim saat form disubmit.
                        // Jadi, tidak perlu call 'storeIn'/'storeOut' langsung dari sini.

                    },
                    (error) => {
                        console.error("Error getting location:", error);
                        let errorMessage = "Tidak dapat mendeteksi lokasi Anda. Pastikan layanan lokasi diaktifkan dan diizinkan.";
                        if (error.code === error.PERMISSION_DENIED) {
                            errorMessage = "Akses lokasi ditolak. Harap izinkan akses lokasi di pengaturan browser Anda.";
                        } else if (error.code === error.POSITION_UNAVAILABLE) {
                            errorMessage = "Informasi lokasi tidak tersedia.";
                        } else if (error.code === error.TIMEOUT) {
                            errorMessage = "Waktu deteksi lokasi habis.";
                        }
                        alert(errorMessage);
                        // Jika gagal mendapatkan lokasi, kembali ke halaman home
                        @this.call('home');
                    },
                    { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 } // Pengaturan akurasi dan timeout
                );
            } else {
                // Jika browser tidak mendukung Geolocation API
                alert("Geolocation tidak didukung oleh browser Anda.");
                @this.call('home'); // Kembali ke home jika tidak didukung
            }
        });
    });
</script>
@endpush
{{-- AKHIR SCRIPT SECTION --}}
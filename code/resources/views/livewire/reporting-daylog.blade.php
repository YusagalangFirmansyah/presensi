<div>
    @if ($isHome)
        <div class="section-header">
            <h1>Reporting DayLog</h1>
        </div>

        <div class="section-body">
            <h2 class="section-title">Reporting List</h2>
            <p class="section-lead">In this section you can manage reporting of application by the user.</p>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-4">

                        </div>
                        <div class="col-4">
                            <input type="text" class="form-control" id="search" placeholder="Search User"
                                wire:model.live.debounce.250ms="search">
                        </div>
                        <div class="col-4 text-right">

                        </div>
                    </div>
                    <br>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name User</th>
                                <th scope="col">Division</th>
                                <th scope="col">Category</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $key => $value)
                                <tr>
                                    <th scope="row">{{ $key + 1 }}</th>
                                    <td>{{ $value->name }}</td>
                                    <td>{{ $value->division->name ?? '' }}</td>
                                    <td>{{ $value->category->name ?? '' }}</td>
                                    <td>
                                        <button wire:click.prevent="userDetail({{ $value->id }})"
                                            class="btn btn-primary">Detail</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif

    @if ($isUserDetail)
        <div class="section-header">
            <h1>Reporting DayLog</h1>
        </div>

        <div class="section-body">
            <h2 class="section-title">Reporting List</h2>
            <p class="section-lead">In this section you can manage reporting of application by the user.</p>
            <div class="card">
                <div class="card-body">
                    <p><strong>User Information</strong></p>
                    <table class="table table-striped table-borderless">
                        <tr>
                            <th>Name</th>
                            <td>:</td>
                            <td>{{ $detail->name }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>:</td>
                            <td>{{ $detail->email }}</td>
                        </tr>
                        <tr>
                            <th>Division</th>
                            <td>:</td>
                            <td>{{ $detail->division->name ?? '' }}</td>
                        </tr>
                        <tr>
                            <th>Category</th>
                            <td>:</td>
                            <td>{{ $detail->category->name ?? '' }}</td>
                        </tr>
                    </table>
                    <div class="mb-3">
                        <button wire:click="exportUserDetail({{ $detail->id }})" class="btn btn-danger">
                            <i class="fas fa-file-pdf"></i> Export PDF
                        </button>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-6">
                            <p><strong>Absence Activity</strong></p>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Day</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">In</th>
                                        <th scope="col">Out</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($absences) === 0)
                                        <tr>
                                            <td colspan="6" class="text-center">No Data Found</td>
                                        </tr>
                                    @endif
                                    @foreach ($absences as $index => $a)
                                        <tr>
                                            <th scope="row">{{ $index + 1 }}</th>
                                            <td>{{ $a->day }}</td>
                                            <td>{{ $a->date }}</td>
                                            <td>
                                                @if ($a->absenHasPresensis[0]->checkin == null)
                                                    <p>-</p>
                                                @elseif($a->absenHasPresensis[0]->checkin != null)
                                                    <p>{{ $a->absenHasPresensis[0]->checkin->created_at }}</p>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($a->absenHasPresensis[0]->checkout == null)
                                                    <p>-</p>
                                                @elseif($a->absenHasPresensis[0]->checkout != null)
                                                    <p>{{ $a->absenHasPresensis[0]->checkout->created_at }}</p>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="#"
                                                    wire:click.prevent="detailAbsence({{ $a->id }})"
                                                    class="btn btn-info">Detail</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="col-6 border-left">
                            <p><strong>Detail Absence Activity</strong></p>
                            @if ($alertAbsence)
                                <div class="alert alert-info alert-has-icon">
                                    <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
                                    <div class="alert-body">
                                        <div class="alert-title">Info</div>
                                        Please select Absence First!
                                    </div>
                                </div>
                            @else
                                <p><strong>General Information</strong></p>
                                <table class="table table-striped table-borderless">
                                    <tr>
                                        <th>Day</th>
                                        <td>:</td>
                                        <td>{{ $absen->day }}</td>
                                    </tr>
                                    <tr>
                                        <th>Date</th>
                                        <td>:</td>
                                        <td>{{ $absen->date }}</td>
                                    </tr>
                                    <tr>
                                        <th>Created At</th>
                                        <td>:</td>
                                        <td>{{ $absen->created_at }}</td>
                                    </tr>
                                </table>
                                <p><strong>Check In Information</strong></p>
                                <table class="table table-striped table-borderless">
                                    <tr>
                                        <th>Check In Time</th>
                                        <td>:</td>
                                        <td>{{ $absen->absenHasPresensis[0]->checkin->created_at }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>:</td>
                                        <td>
                                            @if ($absen->absenHasPresensis[0]->checkin->status == 1)
                                                <span class="badge badge-success">Hadir</span>
                                            @elseif($absen->absenHasPresensis[0]->checkin->status == 2)
                                                <span class="badge badge-warning">Izin</span>
                                            @elseif($absen->absenHasPresensis[0]->checkin->status == 3)
                                                <span class="badge badge-info">Sakit</span>
                                            @elseif($absen->absenHasPresensis[0]->checkin->status == 4)
                                                <span class="badge badge-danger">Alpha</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Plan</th>
                                        <td>:</td>
                                        <td>{{ $absen->absenHasPresensis[0]->checkin->description }}</td>
                                    </tr>
                                    <tr>
                                        <th>Device</th>
                                        <td>:</td>
                                        <td>{{ $absen->absenHasPresensis[0]->checkin->device }}</td>
                                    </tr>
                                    <tr>
                                        <th>Platform / Version</th>
                                        <td>:</td>
                                        <td>{{ $absen->absenHasPresensis[0]->checkin->platform }} /
                                            {{ $absen->absenHasPresensis[0]->checkin->platform_version }}</td>
                                    </tr>
                                    <tr>
                                        <th>Browser / Version</th>
                                        <td>:</td>
                                        <td>{{ $absen->absenHasPresensis[0]->checkin->browser }} /
                                            {{ $absen->absenHasPresensis[0]->checkin->browser_version }}</td>
                                    </tr>
                                </table>
                                <p><strong>Check Out Information</strong></p>
                                @if ($absen->absenHasPresensis[0]->checkout == null)
                                    <div class="alert alert-warning">
                                        <div class="alert-title">Warning</div>
                                        This user not check out yet.
                                    </div>
                                @else
                                    <table class="table table-striped table-borderless">
                                        <tr>
                                            <th>Check Out Time</th>
                                            <td>:</td>
                                            <td>{{ $absen->absenHasPresensis[0]->checkout->created_at }}</td>
                                        </tr>
                                        <tr>
                                            <th>Result</th>
                                            <td>:</td>
                                            <td>{{ $absen->absenHasPresensis[0]->checkin->description }}</td>
                                        </tr>
                                        <tr>
                                            <th>Device</th>
                                            <td>:</td>
                                            <td>{{ $absen->absenHasPresensis[0]->checkin->device }}</td>
                                        </tr>
                                        <tr>
                                            <th>Platform / Version</th>
                                            <td>:</td>
                                            <td>{{ $absen->absenHasPresensis[0]->checkin->platform }} /
                                                {{ $absen->absenHasPresensis[0]->checkin->platform_version }}</td>
                                        </tr>
                                        <tr>
                                            <th>Browser / Version</th>
                                            <td>:</td>
                                            <td>{{ $absen->absenHasPresensis[0]->checkin->browser }} /
                                                {{ $absen->absenHasPresensis[0]->checkin->browser_version }}</td>
                                        </tr>
                                    </table>
                                @endif
                            @endif
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-6">
                            <p><strong>Logbook Activity</strong></p>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Day</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Time</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($logbooks) === 0)
                                        <tr>
                                            <td colspan="5" class="text-center">No Data Found</td>
                                        </tr>
                                    @endif
                                    @foreach ($logbooks as $index => $a)
                                        <tr>
                                            <th scope="row">{{ $index + 1 }}</th>
                                            <td>{{ $a->day }}</td>
                                            <td>{{ $a->date }}</td>
                                            <td>{{ $a->time }}</td>
                                            <td>
                                                <a href="#"
                                                    wire:click.prevent="detailLogbook({{ $a->id }})"
                                                    class="btn btn-info">Detail</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="col-6 border-left">
                            <p><strong>Detail Logbook Activity</strong></p>
                            @if ($alertLogbook)
                                <div class="alert alert-info alert-has-icon">
                                    <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
                                    <div class="alert-body">
                                        <div class="alert-title">Info</div>
                                        Please select Logbook First!
                                    </div>
                                </div>
                            @else
                                <table class="table table-striped table-borderless">
                                    <tr>
                                        <th>Day</th>
                                        <td>:</td>
                                        <td>{{ $logbook->day }}</td>
                                    </tr>
                                    <tr>
                                        <th>Date</th>
                                        <td>:</td>
                                        <td>{{ $logbook->date }}</td>
                                    </tr>
                                    <tr>
                                        <th>Time</th>
                                        <td>:</td>
                                        <td>{{ $logbook->time }}</td>
                                    </tr>
                                    <tr>
                                        <th>Feeling</th>
                                        <td>:</td>
                                        <td>
                                            @if ($logbook->feeling == 1)
                                                <span class="badge badge-danger">Menyebalkan</span>
                                            @elseif ($logbook->feeling == 2)
                                                <span class="badge badge-warning">Membosankan</span>
                                            @elseif ($logbook->feeling == 3)
                                                <span class="badge badge-info">Biasa aja</span>
                                            @elseif ($logbook->feeling == 4)
                                                <span class="badge badge-primary">Menarik</span>
                                            @elseif ($logbook->feeling == 5)
                                                <span class="badge badge-success">Seru</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Activity</th>
                                        <td>:</td>
                                        <td>{{ $logbook->activity }}</td>
                                    </tr>
                                </table>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <p><strong>Leave/Permission Activity</strong></p>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Type</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Reason</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($pengajuans) === 0)
                                        <tr><td colspan="6" class="text-center">No data.</td></tr>
                                    @endif
                                    @foreach ($pengajuans as $index => $p)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td class="text-capitalize">{{ $p->type }}</td>
                                            <td>
                                                @if ($p->type === 'cuti')
                                                    {{ $p->start_date }} to {{ $p->end_date }}
                                                @else
                                                    {{ $p->date }}
                                                @endif
                                            </td>
                                            <td>{{ Str::limit($p->reason, 30) }}</td>
                                            <td>
                                                @if ($p->status === 'pending')
                                                    <span class="badge badge-warning">Pending</span>
                                                @elseif ($p->status === 'approved')
                                                    <span class="badge badge-success">Approved</span>
                                                @else
                                                    <span class="badge badge-danger">Rejected</span>
                                                @endif
                                            </td>
                                            <td>
                                                <button wire:click.prevent="detailPengajuan({{ $p->id }})" class="btn btn-info btn-sm">Detail</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="col-6 border-left">
                            <p><strong>Detail Leave/Permission</strong></p>
                            @if (!$pengajuan)
                                <div class="alert alert-info alert-has-icon">
                                    <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
                                    <div class="alert-body">
                                        <div class="alert-title">Info</div>
                                        Please select Leave/Permission First!
                                    </div>
                                </div>
                            @else
                                <table class="table table-striped table-borderless">
                                    <tr>
                                        <th>Type</th>
                                        <td>:</td>
                                        <td class="text-capitalize">{{ $pengajuan->type }}</td>
                                    </tr>
                                    <tr>
                                        <th>Date</th>
                                        <td>:</td>
                                        <td>
                                            @if ($pengajuan->type === 'cuti')
                                                {{ $pengajuan->start_date }} to {{ $pengajuan->end_date }}
                                            @else
                                                {{ $pengajuan->date }}
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Reason</th>
                                        <td>:</td>
                                        <td>{{ $pengajuan->reason }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>:</td>
                                        <td>
                                            <span class="badge badge-{{ $pengajuan->status === 'pending' ? 'warning' : ($pengajuan->status === 'approved' ? 'success' : 'danger') }}">
                                                {{ ucfirst($pengajuan->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Attachment</th>
                                        <td>:</td>
                                        <td>
                                            @if ($pengajuan->attachment)
                                                <a href="{{ Storage::url($pengajuan->attachment) }}" target="_blank">View</a>
                                            @else
                                                -
                                            @endif
                                        </td>
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

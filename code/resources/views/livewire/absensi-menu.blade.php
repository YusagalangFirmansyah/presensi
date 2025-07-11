<div>
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
                                <a wire:click.prevent="in()" href="#" class="btn btn-outline-light">Check In Now!</a>
                            </div>
                        </div>
                    @endif
                    @if (session()->has('success'))
                        <div class="alert alert-success alert-dismissible show fade">
                            <div class="alert-body">
                            <button class="close" data-dismiss="alert">
                                <span>×</span>
                            </button>
                            {{ session('success') }}
                            </div>
                        </div>
                        <br>
                    @endif
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
                        <a href="#" wire:click="home()" class="btn btn-primary">Back</a>
                        <button class="submit btn btn-success">Save</button>
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
                        <a href="#" wire:click="home()" class="btn btn-primary">Back</a>
                        <button class="submit btn btn-success">Save</button>
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

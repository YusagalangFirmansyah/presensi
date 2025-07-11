<div>
    @if ($isHome)
        <div class="section-header">
            <h1>Log Book Management</h1>
        </div>

        <div class="section-body">
            <h2 class="section-title">Log List</h2>
            <p class="section-lead">In this section you can manage logbook data such as adding and view detail.</p>
            <div class="card">
                <div class="card-body">
                    @if ($alert)
                            <div class="alert alert-primary alert-has-icon">
                                <div class="alert-icon"><i class="fas fa-file-signature"></i></div>
                                <div class="alert-body">
                                    <div class="alert-title">No Today Record</div>
                                    You haven't write your logbook today. <br><br>
                                    <a wire:click.prevent="create()" href="#" class="btn btn-outline-light">Check In Now!</a>
                                </div>
                            </div>
                    @endif
                    <p><strong>Log Book History</strong></p>
                    
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
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Day</th>
                            <th scope="col">Date</th>
                            <th scope="col">Time</th>
                            <th scope="col">Feeling</th>
                            <th scope="col">Description</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if (count($logbooks) === 0)
                            <tr>
                                <td colspan="6" class="text-center">No Data Found</td>
                            </tr>
                        @endif
                        @foreach ($logbooks as $index => $a)
                            <tr>
                                <th scope="row">{{$index + 1}}</th>
                                <td>{{$a->day}}</td>
                                <td>{{$a->date}}</td>
                                <td>{{$a->time}}</td>
                                <td>
                                    @if ($a->feeling == 1)
                                        <span class="badge badge-danger">Menyebalkan</span>
                                    @elseif ($a->feeling == 2)
                                        <span class="badge badge-warning">Membosankan</span>
                                    @elseif ($a->feeling == 3)
                                        <span class="badge badge-info">Biasa aja</span>
                                    @elseif ($a->feeling == 4)
                                        <span class="badge badge-primary">Menarik</span>
                                    @elseif ($a->feeling == 5)
                                        <span class="badge badge-success">Seru</span>
                                    @endif
                                </td>
                                <td>{{$a->activity}}</td>
                            </tr>                    
                        @endforeach
                        </tbody>
                    </table>
                    {{$logbooks->links()}}
                </div>
            </div>
        </div>
    @endif

    @if ($isCreate)
        <div class="section-header">
            <h1>Create Log Book</h1>
        </div>

        <div class="section-body">
            <h2 class="section-title">Create Log</h2>
            <p class="section-lead">In this section you can create logbook data.</p>
            <div class="card">
                <div class="card-body">
                    <form wire:submit.prevent="store">
                        <div class="form-group">
                            <label class="d-block">How's your feeling today?</label>
                            <div class="form-check form-check-inline">
                                <input wire:model="mood" class="form-check-input" type="radio" id="inlineradio1" value="1" name="mood">
                                <label class="form-check-label" for="inlineradio1">Menyebalkan</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input wire:model="mood" class="form-check-input" type="radio" id="inlineradio2" value="2" name="mood">
                                <label class="form-check-label" for="inlineradio2">Membosankan</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input wire:model="mood" class="form-check-input" type="radio" id="inlineradio3" value="3" name="mood">
                                <label class="form-check-label" for="inlineradio3">Biasa aja</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input wire:model="mood" class="form-check-input" type="radio" id="inlineradio4" value="4" name="mood">
                                <label class="form-check-label" for="inlineradio4">Menarik</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input wire:model="mood" class="form-check-input" type="radio" id="inlineradio5" value="5" name="mood">
                                <label class="form-check-label" for="inlineradio5">Seru</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name">Your Activity</label>
                            <input type="text" class="form-control" id="name" wire:model="activity">
                            @error('activity') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <a href="#" wire:click="home()" class="btn btn-primary">Back</a>
                        <button class="submit btn btn-success">Save</button>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>

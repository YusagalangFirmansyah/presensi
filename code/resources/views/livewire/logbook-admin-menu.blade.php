<div>
    @if ($isHome)
        <div class="section-header">
            <h1>Logbook Management</h1>
        </div>

        <div class="section-body">
            <h2 class="section-title">Logbook List</h2>
            <p class="section-lead">In this section you can manage system Logbook data such as adding, changing and deleting.</p>
            <div class="card">
                <div class="card-body">
                    <br>
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name User</th>
                            <th scope="col">Day</th>
                            <th scope="col">Date</th>
                            <th scope="col">Time</th>
                            <th scope="col">Action</th>
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
                                <td>{{$a->user->name}}</td>
                                <td>
                                    {{$a->day}}
                                </td>
                                <td>
                                    {{$a->date}}
                                </td>
                                <td>
                                    {{$a->time}}
                                </td>
                                <td>
                                    <div class="buttons">
                                        <a wire:click.prevent="show({{$a->id}})" href="#" class="btn btn-icon btn-info"><i class="fas fa-info-circle"></i></a>
                                    </div>
                                </td>
                            </tr>                    
                        @endforeach
                        </tbody>
                    </table>
                    {{$logbooks->links()}}
                </div>
            </div>
        </div>
    @endif

    @if ($isDetail)
        <div class="section-header">
            <h1>Logbook Details</h1>
        </div>

        <div class="section-body">
            <h2 class="section-title">Logbook Details</h2>
            <p class="section-lead">In this section you can show detail Logbook data.</p>
            <div class="card">
                <div class="card-body">
                    <p><strong>User Data</strong></p>
                    <table class="table table-striped table-borderless">
                        <tr>
                            <th>
                                Name
                            </th>
                            <td>
                                :
                            </td>
                            <td>
                                {{$logbook->user->name}}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Email
                            </th>
                            <td>
                                :
                            </td>
                            <td>
                                {{$logbook->user->email}}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Category
                            </th>
                            <td>
                                :
                            </td>
                            <td>
                                Internship MBKM
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Division
                            </th>
                            <td>
                                :
                            </td>
                            <td>
                                IT Digital Business
                            </td>
                        </tr>
                    </table>
                    <hr>
                    <p><strong>Logbook Data</strong></p>
                    <table class="table table-striped table-borderless">
                        <tr>
                            <th>
                                Day
                            </th>
                            <td>
                                :
                            </td>
                            <td>
                                {{$logbook->day}}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Date
                            </th>
                            <td>
                                :
                            </td>
                            <td>
                                {{$logbook->date}}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Time
                            </th>
                            <td>
                                :
                            </td>
                            <td>
                                {{$logbook->time}}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Feeling
                            </th>
                            <td>
                                :
                            </td>
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
                            <th>
                                Activity
                            </th>
                            <td>
                                :
                            </td>
                            <td>
                                {{$logbook->activity}}
                            </td>
                        </tr>

                    </table>
                    <a href="#" wire:click="home()" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
    @endif
</div>

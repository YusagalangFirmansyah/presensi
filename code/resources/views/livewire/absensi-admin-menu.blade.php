<div>
    @if ($isHome)
        <div class="section-header">
            <h1>Absence Management</h1>
        </div>

        <div class="section-body">
            <h2 class="section-title">Absence List</h2>
            <p class="section-lead">In this section you can manage system Absence data such as adding, changing and deleting.</p>
            <div class="card">
                <div class="card-body">
                    <br>
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name User</th>
                            <th scope="col">Category</th>
                            <th scope="col">Status</th>
                            <th scope="col">Datetime</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if (count($presensis) === 0)
                            <tr>
                                <td colspan="6" class="text-center">No Data Found</td>
                            </tr>
                        @endif
                        @foreach ($presensis as $index => $a)
                            <tr>
                                <th scope="row">{{$index + 1}}</th>
                                <td>{{$a->user->name}}</td>
                                <td>
                                    @if ($a->category == 0)
                                        <span class="badge badge-warning">Check Out</span>
                                    @elseif($a->category == 1)
                                        <span class="badge badge-success">Check In</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($a->status == 0)
                                        -
                                    @elseif($a->status == 1)
                                        Hadir
                                    @elseif($a->status == 2)
                                        Izin
                                    @elseif($a->status == 3)
                                        Sakit
                                    @elseif($a->status == 4)
                                        Alpha
                                    @endif
                                </td>
                                <td>{{$a->created_at}}</td>
                                <td>
                                    <div class="buttons">
                                        <a wire:click.prevent="detail({{$a->id}})" href="#" class="btn btn-icon btn-info"><i class="fas fa-info-circle"></i></a>
                                    </div>
                                </td>
                            </tr>                    
                        @endforeach
                        </tbody>
                    </table>
                    {{$presensis->links()}}
                </div>
            </div>
        </div>
    @endif

    @if ($isDetail)
        <div class="section-header">
            <h1>Absence Detail</h1>
        </div>

        <div class="section-body">
            <h2 class="section-title">Absence Information</h2>
            <p class="section-lead">In this section you can show detail of the absence information.</p>
            <div class="card">
                <div class="card-body">
                    <p><strong>General Information</strong></p>
                    <table class="table table-striped table-borderless">
                        <tr>
                            <th>Name</th>
                            <td>{{$info->user->name}}</td>
                        </tr>
                        <tr>
                            <th>Date</th>
                            <td>{{$info->created_at}}</td>
                        </tr>
                        <tr>
                            <th>Category</th>
                            <td>
                                @if ($info->category == 0)
                                        <span class="badge badge-warning">Check Out</span>
                                    @elseif($info->category == 1)
                                        <span class="badge badge-success">Check In</span>
                                    @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                @if ($info->status == 0)
                                        -
                                    @elseif($info->status == 1)
                                        Hadir
                                    @elseif($info->status == 2)
                                        Izin
                                    @elseif($info->status == 3)
                                        Sakit
                                    @elseif($info->status == 4)
                                        Alpha
                                    @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Description</th>
                            <td>{{$info->description}}</td>
                        </tr>
                    </table>
                    <hr>
                    <a href="#" wire:click="home()" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
    @endif
</div>

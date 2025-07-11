<div>
    <div class="section-header">
        <h1>Monitoring Absences</h1>
    </div>

    <div class="section-body">
        <h2 class="section-title">Monitoring List</h2>
        <p class="section-lead">In this section you can monitoring the absences.</p>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-4">
                        
                    </div>
                    <div class="col-4">
                        <input type="text" class="form-control" id="search" placeholder="Search User" wire:model.live.debounce.250ms="search">
                    </div>
                    <div class="col-4 text-right">
                        
                    </div>
                </div>
                <br>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Division</th>
                        <th scope="col">Category</th>
                        <th scope="col">In</th>
                        <th scope="col">Out</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if (count($users) === 0)
                        <tr>
                            <td colspan="7" class="text-center">No Data Found</td>
                        </tr>
                    @endif
                    @foreach ($users as $index => $u)
                        <tr>
                            <th scope="row">{{$index + 1}}</th>
                            <td>{{$u->name}}</td>
                            <td>{{$u->email}}</td>
                            <td>{{$u->division->name}}</td>
                            <td>{{$u->category->name}}</td>
                            <td>{{$u}}</td>
                            <td>{{$u->out}}</td>
                        </tr>
                    @endforeach
                </table>
                {{$users->links()}}
            </div>
        </div>
    </div>
</div>

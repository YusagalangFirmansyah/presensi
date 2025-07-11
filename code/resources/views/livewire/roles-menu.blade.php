<div>
    @if ($isHome)
        <div class="section-header">
            <h1>Roles Management</h1>
        </div>

        <div class="section-body">
            <h2 class="section-title">Role List</h2>
            <p class="section-lead">In this section you can manage system role data such as adding, changing and deleting.</p>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-4">
                            
                        </div>
                        <div class="col-4">
                            <input type="text" class="form-control" id="search" placeholder="Search User" wire:model.live.debounce.250ms="search">
                        </div>
                        <div class="col-4 text-right">
                            <button wire:click.prevent="create()" class="btn btn-primary">Create</button>
                        </div>
                    </div>
                    <br>
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
                            <th scope="col">Name</th>
                            <th scope="col">Detail</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if (count($roles) === 0)
                            <tr>
                                <td colspan="4" class="text-center">No Data Found</td>
                            </tr>
                        @endif
                        @foreach ($roles as $index => $role)
                            <tr>
                                <th scope="row">{{$index + 1}}</th>
                                <td>{{$role->name}}</td>
                                <td>
                                    <div class="buttons">
                                        <a href="#" wire:click="show({{$role->id}})" class="btn btn-icon btn-info"><i class="fas fa-info-circle"></i></a>
                                    </div>
                                </td>
                                <td>
                                    <div class="buttons">
                                        <a href="#" wire:click="destroy({{$role->id}})" wire:confirm="Are you sure?" class="btn btn-icon btn-danger"><i class="fas fa-times"></i></a>
                                    </div>
                                </td>
                            </tr>                    
                        @endforeach
                        </tbody>
                    </table>
                    {{$roles->links()}}
                </div>
            </div>
        </div>
    @endif

    @if($isCreate)
        <div class="section-header">
            <h1>Create Role</h1>
        </div>

        <div class="section-body">
            <h2 class="section-title">Create Role</h2>
            <p class="section-lead">In this section you can create new role to authorize in the system.</p>
            <div class="card">
                <form wire:submit.prevent="store">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" wire:model="name">
                            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="buttons">
                            <a href="#" wire:click="back()" class="btn btn-primary">Back</a>
                            <button class="submit btn btn-success">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endif

    @if($isShow)
        <div class="section-header">
            <h1>Detail Role</h1>
        </div>

        <div class="section-body">
            <h2 class="section-title">Detail Role</h2>
            <p class="section-lead">In this section you can see detail permission of role to authorize in the system.</p>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <p><strong>Name</strong></p>
                        </div>
                        <div class="col-6">
                            <p>{{$role->name}}</p>
                        </div>
                    </div>
                    <div class="buttons">
                        <a href="#" wire:click="back()" class="btn btn-primary">Back</a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

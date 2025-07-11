<div>
    @if ($isHome)
        <div class="section-header">
            <h1>Division Management</h1>
        </div>

        <div class="section-body">
            <h2 class="section-title">Division List</h2>
            <p class="section-lead">In this section you can manage system Division data such as adding, changing and deleting.</p>
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
                            <th scope="col">Description</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if (count($divisions) === 0)
                            <tr>
                                <td colspan="4" class="text-center">No Data Found</td>
                            </tr>
                        @endif
                        @foreach ($divisions as $index => $a)
                            <tr>
                                <th scope="row">{{$index + 1}}</th>
                                <td>{{$a->name}}</td>
                                <td>
                                    {{$a->description}}
                                </td>
                                <td>
                                    <div class="buttons">
                                        <a href="#" wire:click="destroy({{$a->id}})" wire:confirm="Are you sure?" class="btn btn-icon btn-danger"><i class="fas fa-times"></i></a>
                                    </div>
                                </td>
                            </tr>                    
                        @endforeach
                        </tbody>
                    </table>
                    {{$divisions->links()}}
                </div>
            </div>
        </div>
    @endif

    @if ($isCreate)
        <div class="section-header">
            <h1>Create Division</h1>
        </div>

        <div class="section-body">
            <h2 class="section-title">Division Create</h2>
            <p class="section-lead">In this section you can create new data Division for user.</p>
            <div class="card">
                <form wire:submit.prevent="store">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" wire:model="name">
                            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="name">Description</label>
                            <input type="text" class="form-control" id="name" wire:model="description">
                            @error('description') <span class="text-danger">{{ $message }}</span> @enderror
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
</div>

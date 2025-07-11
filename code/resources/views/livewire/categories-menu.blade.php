<div>
    @if ($isHome)
        <div class="section-header">
            <h1>Category Management</h1>
        </div>

        <div class="section-body">
            <h2 class="section-title">Category List</h2>
            <p class="section-lead">In this section you can manage system user data such as adding, changing and deleting.</p>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-4">
                            
                        </div>
                        <div class="col-4">
                            <input type="text" class="form-control" id="search" placeholder="Search Category" wire:model.live.debounce.250ms="search">
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
                        @if (count($categories) === 0)
                            <tr>
                                <td colspan="4" class="text-center">No Data Found</td>
                            </tr>
                        @endif
                        @foreach ($categories as $index => $category)
                            <tr>
                                <th scope="row">{{$index + 1}}</th>
                                <td>{{$category->name}}</td>
                                <td>{{$category->description}}</td>
                                <td>
                                    <div class="buttons">
                                        {{-- <a href="#" wire:click.prevent="edit({{$category->id}})" class="btn btn-icon btn-warning"><i class="fas fa-exclamation-triangle"></i></a> --}}
                                        <a href="#" wire:click="destroy({{$category->id}})" wire:confirm="Are you sure?" class="btn btn-icon btn-danger"><i class="fas fa-times"></i></a>
                                    </div>
                                </td>
                            </tr>                    
                        @endforeach
                        </tbody>
                    </table>
                    {{$categories->links()}}
                </div>
            </div>
        </div>
    @endif

    @if ($isCreate)
        <div class="section-header">
            <h1>Create Category</h1>
        </div>

        <div class="section-body">
            <h2 class="section-title">Category Create</h2>
            <p class="section-lead">In this section you can create new data Category for user.</p>
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

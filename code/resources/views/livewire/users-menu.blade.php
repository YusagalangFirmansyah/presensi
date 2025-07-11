<div>
    @if ($isHome)
        <div class="section-header">
            <h1>User Management</h1>
        </div>

        <div class="section-body">
            <h2 class="section-title">User List</h2>
            <p class="section-lead">In this section you can manage system user data such as adding, changing and deleting.</p>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-4">
                            
                        </div>
                        <div class="col-4">
                            <input type="text" class="form-control" id="search" placeholder="Search User" wire:model.live.debounce.250ms="search">
                        </div>
                        <div class="col-4 text-right">
                            <button wire:click.prevent="newuser()" class="btn btn-primary">Create</button>
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
                            <th scope="col">Email</th>
                            <th scope="col">Role</th>
                            <th scope="col">Division</th>
                            <th scope="col">Category</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if (count($users) === 0)
                            <tr>
                                <td colspan="5" class="text-center">No Data Found</td>
                            </tr>
                        @endif
                        @foreach ($users as $index => $user)
                            <tr>
                                <th scope="row">{{$index + 1}}</th>
                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->role->name ?? ''}}</td>
                                <td>{{$user->division->name ?? ''}}</td>
                                <td>{{$user->category->name ?? ''}}</td>
                                <td>
                                    <div class="buttons">
                                        <a href="#" wire:click.prevent="show({{$user->id}})" class="btn btn-icon btn-info"><i class="fas fa-info-circle"></i></a>
                                        <a href="#" wire:click.prevent="edit({{$user->id}})" class="btn btn-icon btn-warning"><i class="fas fa-exclamation-triangle"></i></a>
                                        <a href="#" wire:click="destroy({{$user->id}})" wire:confirm="Are you sure?" class="btn btn-icon btn-danger"><i class="fas fa-times"></i></a>
                                    </div>
                                </td>
                            </tr>                    
                        @endforeach
                        </tbody>
                    </table>
                    {{$users->links()}}
                </div>
            </div>
        </div>
    @endif

    @if($isCreate)
        <div class="section-header">
            <h1>Create User</h1>
        </div>

        <div class="section-body">
            <h2 class="section-title">Create User</h2>
            <p class="section-lead">In this section you can create new user to access the system.</p>
            <div class="card">
                <form wire:submit.prevent="save">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" wire:model="name">
                            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" wire:model="email">
                            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">Password</label>
                            <input type="password" class="form-control" id="password" wire:model="password">
                            @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label>Role User</label>
                            <select class="form-control" name="role" id="role" wire:model="role">
                                <option value="0">Select Role</option>
                                @foreach ($roles as $a)
                                    <option value="{{$a->id}}">{{$a->name}}</option>
                                @endforeach
                            </select>
                            @error('role') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="category">Category User</label>
                            <select class="form-control" name="category" id="category" wire:model="category">
                                <option value="">Select Category</option>
                                @foreach ($categories as $a)
                                    <option value="{{$a->id}}">{{$a->name}}</option>
                                @endforeach
                            </select>
                            @error('category') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="division">Division User</label>
                            <select class="form-control" name="division" id="division" wire:model="division">
                                <option value="">Select Division</option>
                                @foreach ($divisions as $a)
                                    <option value="{{$a->id}}">{{$a->name}}</option>
                                @endforeach
                            </select>
                            @error('division') <span class="text-danger">{{ $message }}</span> @enderror
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

    @if ($isEdit)
        <div class="section-header">
            <h1>Update User</h1>
        </div>

        <div class="section-body">
            <h2 class="section-title">Update User</h2>
            <p class="section-lead">In this section you can update user data.</p>
            <div class="card">
                <form wire:submit.prevent="setUpdate({{$id}})">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" wire:model="name">
                            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" wire:model="email">
                            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
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

    @if ($isShow)
        <div class="section-header">
            <h1>Detail User</h1>
        </div>

        <div class="section-body">
            <h2 class="section-title">Detail User</h2>
            <p class="section-lead">In this section you can show details of the user.</p>
            <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <p><strong>Name</strong></p>
                            </div>
                            <div class="col-6">
                                <p>{{$name}}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <p><strong>Email</strong></p>
                            </div>
                            <div class="col-6">
                                <p>{{$email}}</p>
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

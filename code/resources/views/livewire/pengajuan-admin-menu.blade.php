<div>
    @if ($isHome)
        <div class="section-header">
            <h1>Admin: Leave & Permission Approvals</h1>
        </div>

        <div class="section-body">
            <h2 class="section-title">Request List</h2>
            <p class="section-lead">Manage all leave & permission requests here.</p>

            <div class="card">
                <div class="card-body">
                    @if (session()->has('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @elseif(session()->has('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>User</th>
                                <th>Type</th>
                                <th>Date</th>
                                <th>Reason</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($requests as $idx => $req)
                                <tr>
                                    <td>{{ $idx + $requests->firstItem() }}</td>
                                    <td>{{ $req->user->name }}</td>
                                    <td class="text-capitalize">{{ $req->type == 'cuti' ? 'Leave' : 'Permission' }}</td>
                                    <td>
                                        @if ($req->type === 'cuti')
                                            {{ $req->start_date }} to {{ $req->end_date }}
                                        @else
                                            {{ $req->date }}
                                        @endif
                                    </td>
                                    <td>{{ Str::limit($req->reason, 30) }}</td>
                                    <td>
                                        @if ($req->status === 'pending')
                                            <span class="badge badge-warning">Pending</span>
                                        @elseif ($req->status === 'approved')
                                            <span class="badge badge-success">Approved</span>
                                        @else
                                            <span class="badge badge-danger">Rejected</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="#" wire:click.prevent="show({{ $req->id }})"
                                           class="btn btn-info btn-sm">
                                            <i class="fas fa-info-circle"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No data available.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{ $requests->links() }}
                </div>
            </div>
        </div>
    @endif

    @if ($isDetail)
        <div class="section-header">
            <h1>Request Details</h1>
        </div>

        <div class="section-body">
            <h2 class="section-title">Request Information</h2>
            <p class="section-lead">Validate and approve or reject this request.</p>

            <div class="card">
                <div class="card-body">
                    <p><strong>User Data</strong></p>
                    <table class="table table-borderless">
                        <tr>
                            <th>Name</th><td>: {{ $requestItem->user->name }}</td>
                        </tr>
                        <tr>
                            <th>Email</th><td>: {{ $requestItem->user->email }}</td>
                        </tr>
                        <tr>
                            <th>Role</th><td>: {{ $requestItem->user->role->name }}</td>
                        </tr>
                    </table>

                    <hr>

                    <p><strong>Request Details</strong></p>
                    <table class="table table-borderless">
                        <tr>
                            <th>Type</th>
                            <td>: {{ $requestItem->type == 'cuti' ? 'Leave' : 'Permission' }}</td>
                        </tr>
                        @if ($requestItem->type === 'cuti')
                            <tr>
                                <th>Start Date</th>
                                <td>: {{ $requestItem->start_date }}</td>
                            </tr>
                            <tr>
                                <th>End Date</th>
                                <td>: {{ $requestItem->end_date }}</td>
                            </tr>
                        @else
                            <tr>
                                <th>Permission Date</th>
                                <td>: {{ $requestItem->date }}</td>
                            </tr>
                        @endif
                        <tr>
                            <th>Reason</th>
                            <td>: {{ $requestItem->reason }}</td>
                        </tr>
                        <tr>
                            <th>Attachment</th>
                            <td>:
                                @if ($requestItem->attachment)
                                    <a href="{{ Storage::url($requestItem->attachment) }}" target="_blank">View</a>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>:
                                <span class="badge badge-{{ $requestItem->status === 'pending' ? 'warning' : ($requestItem->status === 'approved' ? 'success' : 'danger') }}">
                                    {{ ucfirst($requestItem->status) }}
                                </span>
                            </td>
                        </tr>
                    </table>

                    @if ($requestItem->status === 'pending')
                        <div class="mt-3">
                            <button class="btn btn-success"
                                onclick="confirm('Approve this request?') && @this.confirmApprove()">
                                Approve
                            </button>
                            <button class="btn btn-danger"
                                onclick="confirm('Reject this request?') && @this.confirmReject()">
                                Reject
                            </button>
                        </div>
                    @endif

                    <div class="mt-3">
                        <a href="#" wire:click.prevent="home()" class="btn btn-secondary">Back</a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

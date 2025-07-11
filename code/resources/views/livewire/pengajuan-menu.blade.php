<div>
    @if ($isHome)
        <div class="section-header">
            <h1>Leave & Permission Requests</h1>
        </div>

        <div class="section-body">
            <h2 class="section-title">Submission History</h2>
            <p class="section-lead">View the status of your leave or permission requests.</p>
            <div class="card">
                <div class="card-body">
                    <a href="#" wire:click.prevent="create" class="btn btn-primary mb-3">Create New Request</a>

                    @if (session()->has('error'))
                        <div class="alert alert-danger alert-dismissible show fade">
                            <div class="alert-body">
                                <button class="close" data-dismiss="alert"><span>×</span></button>
                                {{ session('error') }}
                            </div>
                        </div>
                    @endif

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Type</th>
                                <th>Date</th>
                                <th>Reason</th>
                                <th>Status</th>
                                <th>Attachment</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($requests as $idx => $req)
                                <tr>
                                    <td>{{ $idx + $requests->firstItem() }}</td>
                                    <td class="text-capitalize">{{ $req->type }}</td>
                                    <td>
                                        @if ($req->type === 'cuti')
                                            {{ $req->start_date }} to {{ $req->end_date }}
                                        @else
                                            {{ $req->date }}
                                        @endif
                                    </td>
                                    <td>{{ Str::limit($req->reason, 50) }}</td>
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
                                        @if ($req->attachment)
                                            <a href="{{ Storage::url($req->attachment) }}" target="_blank">View</a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No requests yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{ $requests->links() }}
                </div>
            </div>
        </div>
    @endif

    @if ($isCreate)
        <div class="section-header">
            <h1>Create New Request</h1>
        </div>

        <div class="section-body">
            <h2 class="section-title">Submission Form</h2>
            <p class="section-lead">Please complete the form below.</p>
            <div class="card">
                <div class="card-body">
                    @if ($successMessage)
                        <div class="alert alert-success">
                            {{ $successMessage }}
                        </div>
                    @endif

                    <form wire:submit.prevent="store">
                        <div class="form-group">
                            <label>Request Type</label>
                            <div>
                                @if (!in_array(auth()->user()->role->name, config('cuti.disabled_roles')))
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" id="type-cuti" name="type" value="cuti"
                                            wire:model.lazy="type">
                                        <label class="form-check-label" for="type-cuti">Leave</label>
                                    </div>
                                @endif
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" id="type-izin" name="type" value="izin"
                                        wire:model.lazy="type">
                                    <label class="form-check-label" for="type-izin">Permission</label>
                                </div>
                            </div>
                            @error('type')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div wire:key="type-{{ $type }}">
                            @if ($type === 'cuti' && !in_array(auth()->user()->role->name, config('cuti.disabled_roles')))
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>Start Date</label>
                                        <input type="date" wire:model="start_date"
                                            class="form-control @error('start_date') is-invalid @enderror">
                                        @error('start_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>End Date</label>
                                        <input type="date" wire:model="end_date"
                                            class="form-control @error('end_date') is-invalid @enderror">
                                        @error('end_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            @else
                                <div class="form-group">
                                    <label>Date</label>
                                    <input type="date" wire:model="date"
                                        class="form-control @error('date') is-invalid @enderror">
                                    @error('date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label>Reason</label>
                            <textarea wire:model="reason" rows="3" class="form-control @error('reason') is-invalid @enderror"></textarea>
                            @error('reason')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Attachment (optional, PDF/JPG/PNG)</label>
                            <input type="file" wire:model="attachment"
                                class="form-control-file @error('attachment') is-invalid @enderror">
                            @error('attachment')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <a href="#" wire:click.prevent="home" class="btn btn-primary">Back</a>
                        <button type="submit" class="btn btn-success">Submit Request</button>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>

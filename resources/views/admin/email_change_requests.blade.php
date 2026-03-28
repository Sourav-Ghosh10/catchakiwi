@include('includes/admin-header')
@include('includes/admin-sidebar')

<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">Email Change Requests</h3>
    </div>

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Pending Email Changes</h4>
                    <div class="table-responsive">
                        <table class="table table-light">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Current Email</th>
                                    <th>Requested Email</th>
                                    <th>Requested At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($requests as $req)
                                <tr>
                                    <td>{{ $req->name }} (ID: {{ $req->id }})</td>
                                    <td>{{ $req->email }}</td>
                                    <td>{{ $req->temp_email }}</td>
                                    <td>{{ $req->email_change_requested_at ? \Carbon\Carbon::parse($req->email_change_requested_at)->diffForHumans() : 'N/A' }}</td>
                                    <td>
                                        <form method="POST" action="{{ route('admin.email-change.approve', $req) }}" style="display:inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success"
                                                    onclick="return confirm('Approve email change to {{ $req->temp_email }}?')">
                                                Approve
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.email-change.reject', $req) }}" style="display:inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Reject this email change request?')">
                                                Reject
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('includes/admin-footer')
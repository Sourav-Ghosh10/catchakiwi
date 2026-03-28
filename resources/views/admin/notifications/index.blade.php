@include('includes.admin-header')
@include('includes.admin-sidebar')

<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title"> Notification History </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Notifications</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="card-title mb-0">Sent Notifications</h4>
                        <a href="{{ route('admin.notification.create') }}" class="btn btn-primary">
                            <i class="mdi mdi-plus"></i> Create New Notification
                        </a>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover table-light">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Message Preview</th>
                                    <th>Sent By</th>
                                    <th>Recipients</th>
                                    <th>Sent At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($notifications as $index => $notification)
                                    <tr>
                                        <td>{{ $loop->iteration + ($notifications->currentPage() - 1) * $notifications->perPage() }}</td>
                                        <td><strong>{{ Str::limit($notification->title, 50) }}</strong></td>
                                        <td>{{ Str::limit($notification->message, 80) }}</td>
                                        <td>{{ $notification->admin->name ?? 'System' }}</td>
                                        <td>
                                            <span class="badge badge-info">{{ $notification->sent_count }}</span> users
                                        </td>
                                        <td>
                                            @if($notification->sent_at)
                                                {{ $notification->sent_at->format('d M Y, h:i A') }}<br>
                                                <small class="text-muted">{{ $notification->sent_at->diffForHumans() }}</small>
                                            @else
                                                Not sent
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.notifications.show', $notification) }}" class="btn btn-sm btn-outline-primary" title="View Details">
                                                View Details
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-4">
                                            No notifications sent yet.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $notifications->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('includes.admin-footer')
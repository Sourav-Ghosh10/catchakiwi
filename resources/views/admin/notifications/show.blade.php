@include('includes.admin-header')
@include('includes.admin-sidebar')

<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title"> Notification Details </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.notifications.index') }}">Notifications</a></li>
                <li class="breadcrumb-item active" aria-current="page">Details</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Notification: {{ $notification->title }}</h4>

                    <div class="row">
                        <div class="col-md-8">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="200">Title</th>
                                    <td>{{ $notification->title }}</td>
                                </tr>
                                <tr>
                                    <th>Message</th>
                                    <td>{{ nl2br(e($notification->message)) }}</td>
                                </tr>
                                <tr>
                                    <th>Sent By</th>
                                    <td>{{ $notification->admin?->name ?? 'Deleted Admin' }}</td>
                                </tr>
                                <tr>
                                    <th>Recipients Count</th>
                                    <td>{{ $notification->sent_count }}</td>
                                </tr>
                                <tr>
                                    <th>Sent At</th>
                                    <td>
                                        {{ $notification->sent_at ? $notification->sent_at->format('d M Y, h:i A') : 'Not sent' }}
                                        @if($notification->sent_at)
                                            <br><small class="text-muted">({{ $notification->sent_at->diffForHumans() }})</small>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Selected Parent Categories</th>
                                    <td>
                                        @if($notification->selected_categories)
                                            @foreach(\App\Models\Category::whereIn('id', $notification->selected_categories)->get() as $cat)
                                                <span class="badge badge-primary mr-1">{{ $cat->title }}</span>
                                            @endforeach
                                        @else
                                            <span class="text-muted">None</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Selected Sub Categories</th>
                                    <td>
                                        @if($notification->selected_subcategories)
                                            @foreach(\App\Models\Category::whereIn('id', $notification->selected_subcategories)->get() as $cat)
                                                <span class="badge badge-info mr-1">{{ $cat->title }}</span>
                                            @endforeach
                                        @else
                                            <span class="text-muted">None</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('admin.notifications.index') }}" class="btn btn-secondary">Back to List</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('includes.admin-footer')
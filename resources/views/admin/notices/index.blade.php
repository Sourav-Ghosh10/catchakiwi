@include('includes/admin-header')
@include('includes/admin-sidebar')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="card-title mb-0">Notice Submissions</h4>
                            <div>
                                <span class="badge badge-outline-warning">Pending Approval: {{ $notices->where('status', '0')->count() }}</span>
                                <span class="badge badge-outline-success">Active/Approved: {{ $notices->where('status', '1')->count() }}</span>
                            </div>
                        </div>

                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="color: #fff; float: right; border: none; background: transparent; font-size: 20px;"></button>
                            </div>
                        @endif

                        <!-- Tab filters -->
                        <ul class="nav nav-tabs mb-3" id="noticeTab" role="tablist" style="border-bottom: 1px solid #2c2e33;">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active text-white" id="all-tab" data-bs-toggle="tab" data-bs-target="#all-notices" type="button" role="tab" aria-selected="true" style="background: transparent; border: none;">All Submissions</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link text-warning" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pending-notices" type="button" role="tab" aria-selected="false" style="background: transparent; border: none;">Pending Approval</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link text-success" id="approved-tab" data-bs-toggle="tab" data-bs-target="#approved-notices" type="button" role="tab" aria-selected="false" style="background: transparent; border: none;">Approved / Published</button>
                            </li>
                        </ul>

                        <div class="tab-content" id="noticeTabContent">
                            <!-- All Notices Tab -->
                            <div class="tab-pane fade show active" id="all-notices" role="tabpanel" aria-labelledby="all-tab">
                                @include('admin.notices.table_partial', ['filteredNotices' => $notices])
                            </div>

                            <!-- Pending Notices Tab -->
                            <div class="tab-pane fade" id="pending-notices" role="tabpanel" aria-labelledby="pending-tab">
                                @include('admin.notices.table_partial', ['filteredNotices' => $notices->where('status', '0')])
                            </div>

                            <!-- Approved Notices Tab -->
                            <div class="tab-pane fade" id="approved-notices" role="tabpanel" aria-labelledby="approved-tab">
                                @include('admin.notices.table_partial', ['filteredNotices' => $notices->where('status', '1')])
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal to view full details -->
@foreach($notices as $notice)
<div class="modal fade" id="detailModal{{ $notice->id }}" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel{{ $notice->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content bg-dark text-white">
            <div class="modal-header" style="border-bottom: 1px solid #2c2e33;">
                <h5 class="modal-title" id="detailModalLabel{{ $notice->id }}">{{ $notice->heading }}</h5>
                <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close" style="background: none; border: none; font-size: 24px; color: #fff;">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <strong>User:</strong> {{ $notice->user_name ?? 'N/A' }} ({{ $notice->user_email ?? 'N/A' }})
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Country:</strong> {{ $notice->country_name ?? 'N/A' }}
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Category:</strong> {{ $notice->noticecategory->category ?? 'N/A' }}
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Type:</strong> 
                        @if($notice->noticetype === 'feature')
                            <span class="badge badge-info">28-Day Featured Notice ($3.00)</span>
                        @else
                            <span class="badge badge-secondary">7-Day Free Notice</span>
                        @endif
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Submitted At:</strong> {{ \Carbon\Carbon::parse($notice->created_at)->format('d M Y, h:i A') }}
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Expiry Date (notice_EXPIRE):</strong> 
                        <span class="text-info">{{ $notice->notice_EXPIRE ? \Carbon\Carbon::parse($notice->notice_EXPIRE)->format('d M Y, h:i A') : 'N/A' }}</span>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Status:</strong> 
                        @if($notice->status === '1')
                            <span class="badge badge-success">Approved / Published</span>
                        @else
                            <span class="badge badge-warning">Pending Approval</span>
                        @endif
                    </div>

                    @if($notice->town_suburb)
                    <div class="col-md-6 mb-3">
                        <strong>Town/Suburb:</strong> {{ $notice->town_suburb }}
                    </div>
                    @endif
                    @if($notice->looking_for)
                    <div class="col-md-6 mb-3">
                        <strong>Looking for:</strong> {{ $notice->looking_for }}
                    </div>
                    @endif
                    @if($notice->job_location)
                    <div class="col-md-6 mb-3">
                        <strong>Job Location:</strong> {{ $notice->job_location }}
                    </div>
                    @endif
                    @if($notice->start_date)
                    <div class="col-md-6 mb-3">
                        <strong>Start Date:</strong> {{ $notice->start_date }}
                    </div>
                    @endif
                    @if($notice->budget)
                    <div class="col-md-6 mb-3">
                        <strong>Budget:</strong> {{ $notice->budget }}
                    </div>
                    @endif

                    <div class="col-12 mb-3">
                        <strong>Content:</strong>
                        <div class="p-3 bg-secondary rounded text-white" style="white-space: pre-wrap; background-color: #2a3038 !important; border: 1px solid #2c2e33;">{{ $notice->content }}</div>
                    </div>

                    @if($notice->images->isNotEmpty())
                    <div class="col-12 mb-3">
                        <strong>Images:</strong>
                        <div class="d-flex flex-wrap gap-2 mt-2">
                            @foreach($notice->images as $img)
                                <a href="{{ asset($img->img_path) }}" target="_blank">
                                    <img src="{{ asset($img->img_path) }}" alt="" style="width: 120px; height: 90px; object-fit: cover; border-radius: 4px; border: 1px solid #2c2e33; margin-right: 8px;">
                                </a>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            <div class="modal-footer" style="border-top: 1px solid #2c2e33;">
                @if($notice->status === '0')
                    <form action="{{ route('admin.notices.approve', $notice->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        <button type="submit" class="btn btn-success">Make Active</button>
                    </form>
                @else
                    <form action="{{ route('admin.notices.reject', $notice->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        <button type="submit" class="btn btn-warning">Make Inactive</button>
                    </form>
                @endif
                @if($notice->noticetype !== 'feature')
                    <form action="{{ route('admin.notices.upgrade', $notice->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        <button type="submit" class="btn btn-primary" onclick="return confirm('Upgrade to featured notice for free?');">Upgrade</button>
                    </form>
                @endif
                <a href="{{ route('admin.notices.edit', $notice->id) }}" class="btn btn-secondary">Edit</a>
                <form action="{{ route('admin.notices.destroy', $notice->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this notice?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endforeach

@include('includes/admin-footer')

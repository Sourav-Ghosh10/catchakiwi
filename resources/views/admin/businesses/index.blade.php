@include('includes/admin-header')
@include('includes/admin-sidebar')

<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">Business Management</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Business</a></li>
                <li class="breadcrumb-item active" aria-current="page">All Businesses</li>
            </ol>
        </nav>
    </div>

    {{-- Success Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Business Details</h4>
                    
                    {{-- Search and Filter Form --}}
                    <form method="GET" action="{{ route('admin.businesses.index') }}" class="mb-4">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" 
                                       placeholder="Search by business name, owner name, email..." 
                                       value="{{ request('search') }}">
                            </div>
                            <div class="col-md-3">
                                <select name="status" class="form-control">
                                    <option value="">All Status</option>
                                    <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary">Search</button>
                                <a href="{{ route('admin.businesses.index') }}" class="btn btn-secondary">Clear</a>
                            </div>
                        </div>
                    </form>

                    {{-- Make sure table is visible --}}
                    <div class="table-responsive">
                        <table id="businessesTable" class="table table-light">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Business ID</th>
                                    <th>Company Name</th>
                                    <th>Display Name</th>
                                    <th>Owner Name</th>
                                    <th>Owner Email</th>
                                    <th>Primary Category</th>
                                    <th>Country</th>
                                    <th>Contact Person</th>
                                    <th>Phone</th>
                                    <th>Created Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($businesses) && $businesses->count() > 0)
                                    @php $i = ($businesses->currentPage() - 1) * $businesses->perPage(); @endphp
                                    @foreach($businesses as $business)
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td>{{ ($business->country_shortname ?? 'BIZ') . '000' . $business->id }}</td>
                                        <td>{{ $business->company_name ?? 'N/A' }}</td>
                                        <td>{{ $business->display_name ?? 'N/A' }}</td>
                                        <td>{{ $business->user_name ?? 'N/A' }}</td>
                                        <td>{{ $business->user_email ?? 'N/A' }}</td>
                                        <td>{{ $business->primary_category_name ?? 'N/A' }}</td>
                                        <td>{{ $business->country_name ?? 'N/A' }}</td>
                                        <td>{{ $business->contact_person ?? 'N/A' }}</td>
                                        <td>{{ $business->main_phone ?? 'N/A' }}</td>
                                        <td>{{ $business->created_at ? \Carbon\Carbon::parse($business->created_at)->format('Y-m-d') : 'N/A' }}</td>
                                        <td>
                                            @if(isset($business->status) && $business->status == '1')
                                                <span class="badge badge-success">Active</span>
                                            @else
                                                <span class="badge badge-danger">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.businesses.edit', $business->id) }}" 
                                               class="btn btn-sm btn-primary">Edit</a>
                                            
                                            @if(isset($business->status) && $business->status == '1')
                                                <a href="{{ route('admin.businesses.change-status', $business->id) }}" 
                                                   class="btn btn-sm btn-warning" 
                                                   onclick="return confirm('Are you sure you want to deactivate this business?');">
                                                   Deactivate
                                                </a>
                                            @else
                                                <a href="{{ route('admin.businesses.change-status', $business->id) }}" 
                                                   class="btn btn-sm btn-success" 
                                                   onclick="return confirm('Are you sure you want to activate this business?');">
                                                   Activate
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="13" class="text-center">
                                            @if(isset($businesses))
                                                No businesses found.
                                            @else
                                                Error loading businesses data.
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination and Results Info --}}
                    @if(isset($businesses) && method_exists($businesses, 'links'))
                        <div class="row mt-4">
                            <div class="col-md-6 d-flex align-items-center">
                                <div class="dataTables_info">
                                    <span class="text-muted">
                                        Showing {{ $businesses->firstItem() ?? 0 }} to {{ $businesses->lastItem() ?? 0 }} 
                                        of {{ $businesses->total() ?? 0 }} results
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6 d-flex justify-content-end">
                                <div class="dataTables_paginate">
                                    {{ $businesses->appends(request()->query())->links('pagination::bootstrap-4') }}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@include('includes/admin-footer')

<style>
/* Custom styles to ensure proper table display */
.table-responsive {
    overflow-x: auto;
    background: white;
    border-radius: 5px;
}

.table {
    margin-bottom: 0;
    background-color: white;
}

.table th {
    background-color: #343a40;
    color: white;
    border-color: #454d55;
    font-weight: 600;
    font-size: 12px;
    padding: 12px 8px;
    vertical-align: middle;
}

.table td {
    padding: 10px 8px;
    vertical-align: middle;
    border-color: #dee2e6;
    font-size: 13px;
}

.table tbody tr:hover {
    background-color: #f8f9fa;
}

.btn-group-vertical .btn {
    font-size: 11px;
    padding: 4px 8px;
}

.badge {
    font-size: 11px;
    padding: 4px 8px;
}

/* Fix pagination styling */
.pagination {
    margin: 0;
    padding: 0;
}

.page-item .page-link {
    color: #6c757d;
    background-color: #fff;
    border: 1px solid #dee2e6;
    padding: 8px 12px;
    font-size: 14px;
    line-height: 1.25;
    border-radius: 4px;
    margin: 0 2px;
}

.page-item.active .page-link {
    background-color: #007bff;
    border-color: #007bff;
    color: white;
}

.page-item.disabled .page-link {
    color: #6c757d;
    background-color: #fff;
    border-color: #dee2e6;
    opacity: 0.5;
}

.page-item .page-link:hover {
    color: #0056b3;
    background-color: #e9ecef;
    border-color: #dee2e6;
}

.dataTables_info {
    padding-top: 8px;
    color: #6c757d;
    font-size: 14px;
}

.dataTables_paginate {
    display: flex;
    justify-content: flex-end;
    align-items: center;
}

/* Ensure content is visible */
.content-wrapper {
    background-color: #f4f5fa;
    min-height: 100vh;
}

.card {
    box-shadow: 0 0 20px rgba(0,0,0,0.1);
    border: none;
}

.card-body {
    padding: 25px;
}

/* Custom pagination container */
.pagination-wrapper {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 0;
    border-top: 1px solid #dee2e6;
    margin-top: 20px;
}

/* Override default Laravel pagination styling */
.pagination .page-link {
    position: relative;
    display: block;
    color: #007bff;
    text-decoration: none;
    background-color: #fff;
    border: 1px solid #dee2e6;
    transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

.pagination .page-item:first-child .page-link {
    border-top-left-radius: 4px;
    border-bottom-left-radius: 4px;
}

.pagination .page-item:last-child .page-link {
    border-top-right-radius: 4px;
    border-bottom-right-radius: 4px;
}

.pagination .page-item.active .page-link {
    z-index: 3;
    color: #fff;
    background-color: #007bff;
    border-color: #007bff;
}

.pagination .page-item.disabled .page-link {
    color: #6c757d;
    pointer-events: none;
    background-color: #fff;
    border-color: #dee2e6;
}
</style>
                </div>
            </div>
        </div>
    </div>
</div>

@include('includes/admin-footer')
<div class="table-responsive">
    <table class="table table-dark">
        <thead>
            <tr>
                <th> # </th>
                <th> User </th>
                <th> Country </th>
                <th> Category </th>
                <th> Type </th>
                <th> Heading </th>
                <th> Status </th>
                <th> Expires On </th>
                <th> Actions </th>
            </tr>
        </thead>
        <tbody>
            @forelse($filteredNotices as $key => $notice)
            <tr>
                <td> {{ $key + 1 }} </td>
                <td> 
                    <div style="font-weight: bold;">{{ $notice->user_name ?? 'N/A' }}</div>
                    <div style="font-size: 11px; color: #8f94a2;">{{ $notice->user_email ?? 'N/A' }}</div>
                </td>
                <td> {{ $notice->country_name ?? 'N/A' }} </td>
                <td> {{ $notice->noticecategory->category ?? 'N/A' }} </td>
                <td>
                    @if($notice->noticetype === 'feature')
                        <span class="badge badge-info" style="font-size: 10px; padding: 4px 8px;">28-Day Featured ($3)</span>
                    @else
                        <span class="badge badge-secondary" style="font-size: 10px; padding: 4px 8px;">7-Day Free</span>
                    @endif
                </td>
                <td> 
                    <span title="{{ $notice->heading }}">{{ Str::limit($notice->heading, 30) }}</span> 
                </td>
                <td>
                    @if($notice->status === '1')
                        <span class="badge badge-success">Approved</span>
                    @else
                        <span class="badge badge-warning">Pending Approval</span>
                    @endif
                </td>
                <td>
                    @if($notice->notice_EXPIRE)
                        <span class="{{ \Carbon\Carbon::parse($notice->notice_EXPIRE)->isPast() ? 'text-danger' : 'text-success' }}">
                            {{ \Carbon\Carbon::parse($notice->notice_EXPIRE)->format('d M Y') }}
                        </span>
                    @else
                        <span class="text-muted">N/A</span>
                    @endif
                </td>
                <td>
                    <button type="button" class="btn btn-outline-info btn-sm" data-bs-toggle="modal" data-bs-target="#detailModal{{ $notice->id }}">View Details</button>
                    @if($notice->status === '0')
                        <form action="{{ route('admin.notices.approve', $notice->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm">Approve</button>
                        </form>
                    @else
                        <form action="{{ route('admin.notices.reject', $notice->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            <button type="submit" class="btn btn-warning btn-sm">Reject</button>
                        </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9" class="text-center">No notices found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

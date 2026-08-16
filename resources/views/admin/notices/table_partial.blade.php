<div class="table-responsive">
    <table class="table table-dark sortable-table" id="noticesTable-{{ uniqid() }}">
        <thead>
            <tr>
                <th class="sortable-col" data-col="0" style="cursor:pointer; white-space:nowrap; user-select:none;">
                    # <span class="sort-icon text-muted" style="font-size:11px;">⇅</span>
                </th>
                <th class="sortable-col" data-col="1" style="cursor:pointer; white-space:nowrap; user-select:none;">
                    User <span class="sort-icon text-muted" style="font-size:11px;">⇅</span>
                </th>
                <th class="sortable-col" data-col="2" style="cursor:pointer; white-space:nowrap; user-select:none;">
                    Country <span class="sort-icon text-muted" style="font-size:11px;">⇅</span>
                </th>
                <th class="sortable-col" data-col="3" style="cursor:pointer; white-space:nowrap; user-select:none;">
                    Category <span class="sort-icon text-muted" style="font-size:11px;">⇅</span>
                </th>
                <th class="sortable-col" data-col="4" style="cursor:pointer; white-space:nowrap; user-select:none;">
                    Type <span class="sort-icon text-muted" style="font-size:11px;">⇅</span>
                </th>
                <th class="sortable-col" data-col="5" style="cursor:pointer; white-space:nowrap; user-select:none;">
                    Heading <span class="sort-icon text-muted" style="font-size:11px;">⇅</span>
                </th>
                <th class="sortable-col" data-col="6" style="cursor:pointer; white-space:nowrap; user-select:none;">
                    Status <span class="sort-icon text-muted" style="font-size:11px;">⇅</span>
                </th>
                <th class="sortable-col" data-col="7" style="cursor:pointer; white-space:nowrap; user-select:none;">
                    Expires On <span class="sort-icon text-muted" style="font-size:11px;">⇅</span>
                </th>
                <th style="white-space:nowrap;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($filteredNotices as $notice)
            <tr>
                <td> {{ $notice->id }} </td>
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
                <td data-sort="{{ $notice->notice_EXPIRE ?? '0000-00-00' }}">
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
                            <button type="submit" class="btn btn-success btn-sm">Make Active</button>
                        </form>
                    @else
                        <form action="{{ route('admin.notices.reject', $notice->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            <button type="submit" class="btn btn-warning btn-sm">Make Inactive</button>
                        </form>
                    @endif
                    @if($notice->noticetype !== 'feature')
                        <form action="{{ route('admin.notices.upgrade', $notice->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            <button type="submit" class="btn btn-primary btn-sm" onclick="return confirm('Upgrade to featured notice for free?');">Upgrade</button>
                        </form>
                    @endif
                    <a href="{{ route('admin.notices.edit', $notice->id) }}" class="btn btn-secondary btn-sm">Edit</a>
                    <form action="{{ route('admin.notices.destroy', $notice->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this notice?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
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

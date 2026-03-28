@include('includes/admin-header')
@include('includes/admin-sidebar')
<div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title"> Basic Tables </h3>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#">Tables</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Basic tables</li>
                </ol>
              </nav>
            </div>
            <div class="row">
              
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Users Details</h4>
                    </p>
                    <div class="table-responsive">
                      <table id="usersTable" class="table table-light">
                        <thead>
                          <tr>
                            <th> # </th>
                            <th> Registration Number </th>
                            <th> Name </th>
                            <th> Country </th> 
                            <th> State/Region </th>
                            <th> City/District </th>
                            <th> Registration IP </th>
                            <th> Registration Country </th>
                            <th> User Email </th>
                            <th> Created Date </th>
                            <th> Last Login IP Country </th>
                            <th> Last Login Date & Time </th>
                            <th> Logins in Past 3 Months </th>
                            <th> Businesses Owned </th>
                            <th> Agent </th>
                            <th> Action </th>
                          </tr>
                        </thead>
                        <tbody>
                          @php $i = 0; @endphp
                          @foreach($users as $usr)
                          <tr>      
                            <td> {{ ++$i }} </td>
                            <td> {{ $usr->shortname."000".$usr->id }} </td>
                            <td> {{ $usr->name }} </td>
                            <td> {{ $usr->country_name }} </td>
                            <td> {{ $usr->state }} </td>
                            <td> {{ $usr->city }} </td>
                            <td> {{ $usr->ip }} </td> 
                            <td> {{ $usr->country_name }} </td>
                            <td> {{ $usr->email }} </td>
                            <td> {{ $usr->created_at }} </td>
                            <td> {{ $usr->last_login_country }} </td>
                            <td> {{ $usr->last_login_at }} </td>
                            <td> {{ $usr->login_count }} </td>
                            <td> 
                                <a href="javascript:void(0)" 
                                   class="business-count-link" 
                                   data-user-id="{{ $usr->id }}" 
                                   data-user-name="{{ $usr->name }}">
                                   {{ $usr->businessCount }}
                                </a>
                            </td>
                            <td> {{ $usr->agent }} </td>
                            <td> 
                                <a href="{{ route('admin.users.edit', ['id' => $usr->id]) }}" class="btn btn-sm btn-primary">Edit</a>
                                @if($usr->status=="1")
                                    <a href="{{ route('admin.users.change-status', ['id' => $usr->id]) }}" 
                                       class="btn btn-sm btn-danger" 
                                       onclick="return confirm('Are you sure you want to lock this account?');">Lock Account</a>
                                @else
                                    <a href="{{ route('admin.users.change-status', ['id' => $usr->id]) }}" 
                                       class="btn btn-sm btn-success" 
                                       onclick="return confirm('Are you sure you want to unlock this account?');">Unlock Account</a>
                                @endif
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

<!-- Custom Business Modal -->
<div id="businessModal" class="custom-modal" style="display: none;">
    <div class="custom-modal-overlay"></div>
    <div class="custom-modal-content">
        <div class="custom-modal-header">
            <h5 id="businessModalLabel">Business List</h5>
            <button type="button" class="custom-modal-close">&times;</button>
        </div>
        <div class="custom-modal-body">
            <div id="businessLoader" class="text-center" style="display: none;">
                <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <p>Loading businesses...</p>
            </div>
            <div id="businessContent">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Business Name</th>
                                <th>Display Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Status</th>
                                <th>Created Date</th>
                            </tr>
                        </thead>
                        <tbody id="businessTableBody">
                            <!-- Dynamic content will be loaded here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="custom-modal-footer">
            <button type="button" class="btn btn-secondary custom-modal-close-btn">Close</button>
        </div>
    </div>
</div>

<style>
/* Custom Modal Styles */
.custom-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 1050;
}

.custom-modal-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
}

.custom-modal-content {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: white;
    border-radius: 0.3rem;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    max-width: 90%;
    max-height: 90%;
    width: 800px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
}

.custom-modal-header {
    padding: 1rem;
    border-bottom: 1px solid #dee2e6;
    display: flex;
    justify-content: between;
    align-items: center;
    background-color: #f8f9fa;
}

.custom-modal-header h5 {
    margin: 0;
    flex-grow: 1;
    color: #333;
}

.custom-modal-close {
    background: none;
    border: none;
    font-size: 1.5rem;
    color: #999;
    cursor: pointer;
    padding: 0;
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.custom-modal-close:hover {
    color: #333;
}

.custom-modal-body {
    padding: 1rem;
    flex-grow: 1;
    overflow-y: auto;
    max-height: 400px;
}

.custom-modal-footer {
    padding: 1rem;
    border-top: 1px solid #dee2e6;
    background-color: #f8f9fa;
    text-align: right;
}

.business-count-link {
    color: #007bff;
    text-decoration: none;
    cursor: pointer;
}

.business-count-link:hover {
    color: #0056b3;
    text-decoration: underline;
}

.spinner-border {
    width: 3rem;
    height: 3rem;
    border: 0.25em solid currentColor;
    border-right-color: transparent;
    border-radius: 50%;
    animation: spinner-border 0.75s linear infinite;
}

@keyframes spinner-border {
    to {
        transform: rotate(360deg);
    }
}
</style>
@include('includes/admin-footer')
<script>
    // Handle business count click
    $('.business-count-link').on('click', function() {
        var userId = $(this).data('user-id');
        var userName = $(this).data('user-name');
        
        // Update modal title
        $('#businessModalLabel').text('Business List for ' + userName);
        
        // Show custom modal
        $('#businessModal').fadeIn(200);
        $('body').css('overflow', 'hidden');
        
        // Show loader
        $('#businessLoader').show();
        $('#businessContent').hide();
        
        // Fetch business data
        fetchUserBusinesses(userId);
    });
    
    // Handle modal close
    $('.custom-modal-close, .custom-modal-close-btn, .custom-modal-overlay').on('click', function() {
        closeCustomModal();
    });
    
    // Prevent modal content click from closing modal
    $('.custom-modal-content').on('click', function(e) {
        e.stopPropagation();
    });
    
    // Close modal on escape key
    $(document).on('keydown', function(e) {
        if (e.keyCode === 27) { // Escape key
            closeCustomModal();
        }
    });


function closeCustomModal() {
    $('#businessModal').fadeOut(200);
    $('body').css('overflow', 'auto');
}

function fetchUserBusinesses(userId) {
    $.ajax({
        url: '{{ route("admin.users.businesses") }}',
        method: 'POST',
        data: {
            user_id: userId,
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            $('#businessLoader').hide();
            $('#businessContent').show();
            
            var tableBody = $('#businessTableBody');
            tableBody.empty();
            
            if (response.businesses && response.businesses.length > 0) {
                response.businesses.forEach(function(business) {
                  	var businessUrl = '/' + 
                        (business.country_shortname || 'in') + 
                        '/business/' + 
                        (business.primary_category_url || 'category') + 
                        '/' + 
                        (business.secondary_category_url || 'subcategory') + 
                        '/' + 
                        business.slug;
                    var row = '<tr>' +
                        '<td><a href="' + businessUrl + '" target="_blank" class="text-primary">' + business.company_name + '</a></td>' +
                        '<td>' + (business.display_name || '-') + '</td>' +
                        '<td>' + (business.email_address || '-') + '</td>' +
                        '<td>' + (business.main_phone || '-') + '</td>' +
                        '<td>' + 
                            (business.status == 1 ? 
                                '<span class="badge badge-success">Active</span>' : 
                                '<span class="badge badge-danger">Inactive</span>') +
                        '</td>' +
                        '<td>' + formatDate(business.created_at) + '</td>' +
                        '</tr>';
                    tableBody.append(row);
                });
            } else {
                tableBody.append('<tr><td colspan="6" class="text-center">No businesses found</td></tr>');
            }
        },
        error: function(xhr, status, error) {
            $('#businessLoader').hide();
            $('#businessContent').show();
            $('#businessTableBody').html('<tr><td colspan="7" class="text-center text-danger">Error loading businesses</td></tr>');
            console.error('Error fetching businesses:', error);
        }
    });
}

function formatDate(dateString) {
    if (!dateString) return '-';
    var date = new Date(dateString);
    return date.toLocaleDateString() + ' ' + date.toLocaleTimeString();
}
</script>


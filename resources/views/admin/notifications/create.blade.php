@include('includes.admin-header')
@include('includes.admin-sidebar')

<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title"> Send Notification </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.notifications.index') }}">Notifications</a></li>
                <li class="breadcrumb-item active" aria-current="page">Create</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Create New Notification</h4>

                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.notification.send') }}" method="POST">
                        @csrf
						<div class="form-group">
                            <label>Select Country <span class="text-danger">*</span></label>
                            <select name="country" id="countrySelect" class="form-control" required>
                                <option value="">-- Select Country --</option>
                                @foreach($countries as $country)
                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- Title -->
                        <div class="form-group">
                            <label for="title">Notification Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" required>
                        </div>

                        <!-- Message -->
                        <div class="form-group">
                            <label for="message">Message <span class="text-danger">*</span></label>
                            <textarea name="message" id="message" class="form-control" rows="6" cols="50" style="height: 200px;" required>{{ old('message') }}</textarea>
                        </div>

                        <!-- Parent Categories -->
                        <div class="form-group">
                            <label>Select Parent Categories (Multiple) </label>
                            <select name="parent_categories[]" id="parentCategories" class="form-control select2" multiple="multiple" style="width:100%;">
                                @foreach($parentCategories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->title }}</option>
                                @endforeach
                            </select>
                            <small class="text-muted">Hold Ctrl/Cmd to select multiple</small>
                        </div>

                        <!-- Sub Categories -->
                        <div class="form-group">
                            <label>Sub Categories</label>
                            <select name="subcategories[]" id="subcategories" class="form-control select2" multiple="multiple" style="width:100%;" disabled>
                                <option>Loading subcategories...</option>
                            </select>
                        </div>

                        <!-- Users -->
                        <div class="form-group">
                            <label>Recipients (Users) <span class="text-danger">*</span></label>
                            <select name="users[]" id="users" class="form-control select2" multiple="multiple" style="width:100%;" required disabled>
                                <option>Loading users...</option>
                            </select>
                            <button type="button" id="selectAllUsers" class="btn btn-sm btn-info mt-2">Select All Visible Users</button>
                            <small class="text-muted d-block mt-1">Users are loaded based on selected categories</small>
                        </div>

                        <!-- Submit -->
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary mr-2">Send Notification</button>
                            <a href="{{ route('admin.notifications.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@include('includes.admin-footer')

<!-- Select2 CSS & JS (if not already in your template) -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function() {
    // Initialize Select2 for better UX
    $('.select2').select2({
        placeholder: "Select options...",
        allowClear: true
    });

    // Load subcategories when parent changes
    $('#parentCategories').on('change', function() {
        const selected = $(this).val();
        $('#subcategories, #users').empty().prop('disabled', true).trigger('change.select2');

        if (selected && selected.length > 0) {
            $.post('{{ route("admin.notification.subcategories") }}', {
                _token: '{{ csrf_token() }}',
                parent_ids: selected
            }).done(function(data) {
                $('#subcategories').prop('disabled', false);
                data.forEach(cat => {
                    $('#subcategories').append(`<option value="${cat.id}">${cat.title}</option>`);
                });
                $('#subcategories').trigger('change.select2');
                loadUsers();
            });
        }
    });

    // Load users when subcategories change
    $('#subcategories').on('change', loadUsers);

    function loadUsers() {
        const countryId = $('#countrySelect').val();
        const cats = $('#parentCategories').val() || [];
        const subs = $('#subcategories').val() || [];

        $('#users').empty().prop('disabled', true).append('<option>Loading users...</option>').trigger('change.select2');

        $.post('{{ route("admin.notification.users") }}', {
            _token: '{{ csrf_token() }}',
          	country_id: countryId,
            category_ids: cats,
            subcategory_ids: subs
        }).done(function(data) {
            $('#users').empty().prop('disabled', false);
            if (data.length === 0) {
                $('#users').append('<option>No users found for selected categories</option>');
            } else {
                data.forEach(user => {
                    $('#users').append(`<option value="${user.id}">${user.name} (${user.email})</option>`);
                });
            }
            $('#users').trigger('change.select2');
        });
    }

    // Select All Users
    $('#selectAllUsers').on('click', function() {
        $('#users option').prop('selected', true);
        $('#users').trigger('change.select2');
    });
  	function loadUsers() {
        const countryId = $('#countrySelect').val();
        
        // If no country selected, disable and clear users
        if (!countryId) {
            $('#subcategories, #users').empty().prop('disabled', true).trigger('change.select2');
            $('#users').append('<option>Select a country first</option>');
            return;
        }


        $('#users').empty().prop('disabled', true)
            .append('<option>Loading users...</option>')
            .trigger('change.select2');

        $.post('{{ route("admin.notification.users") }}', {
            _token: '{{ csrf_token() }}',
            country_id: countryId,
        }).done(function(data) {
            $('#users').empty().prop('disabled', false);

            if (data.length === 0) {
                $('#users').append('<option>No users found</option>');
            } else {
                data.forEach(user => {
                    $('#users').append(`<option value="${user.id}">${user.name} (${user.email})</option>`);
                });
            }
            $('#users').trigger('change.select2');
        }).fail(function() {
            $('#users').empty().prop('disabled', false)
                .append('<option>Error loading users</option>')
                .trigger('change.select2');
        });
    }
  	$('#countrySelect').on('change', function() {
        // Reset categories and subcategories when country changes
        $('#parentCategories').val(null).trigger('change.select2');
        $('#subcategories').empty().prop('disabled', true).trigger('change.select2');
        
        loadUsers(); // Load all users for this country
    });
});
</script>
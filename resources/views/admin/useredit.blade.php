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
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.users.update',$user->id) }}">
                            @csrf
                            @method('PUT')
                            
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>
                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $user->name) }}" required autocomplete="name">
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">Email</label>
                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $user->email) }}" required autocomplete="email">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <input type="hidden" name="hiddentownid" id="hiddentownid" value="{{ $user->suburb_id }}">
                            <div class="form-group row">
                                <label for="country" class="col-md-4 col-form-label text-md-right">Country</label>
                                <div class="col-md-6">
                                    <select class="livesearch form-control" name="country" id="country" placeholder="Select Country" >
                                          <option value="" disabled selected>Select Country</option>
                                          @if(!empty($country))
                                            @foreach($country as $cnty)
                                                <option value="{{$cnty['id']}}" <?= ($suburb->shortname==$cnty['shortname'])?'selected':'' ?>>{{$cnty['name']}}</option>
                                            @endforeach
                                          @endif;
                                    </select>
                                    @error('country')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="towns_id" id="sub_lebel" class="col-md-4 col-form-label text-md-right">
                                  @if($suburb->shortname == "IN")
                                  	City State
                                  @elseif($suburb->shortname == "NZ")
                                      City/District, Suburb
                                  @elseif($suburb->shortname == "UK")
                                  	Region, County
                                  @elseif($suburb->shortname == "US")
                                  	City State
                                  @elseif($suburb->shortname == "AU")
                                  	City State/Territory
                                  @elseif($suburb->shortname == "CN")
                                  	Provinces, Cities
                                  @else
                                      City/State
                                  @endif
                                </label>
                                <div class="col-md-6">
                                    <select class="livesearch form-control" name="suburb_id" id="towns_id" placeholder="Type Suburb/City" ></select>
                                    @error('towns_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Update
                                    </button>
                                  	<a href="{{ route('admin.userlist') }}" class="btn btn-info">
                                        Cancel
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                  </div>
                </div>
              </div>
              
            </div>
          </div>
@include('includes/admin-footer')
<script>
    $(document).ready(function () {
        //$('#country').trigger('change');
    })
</script>
<style>
/* Fix for suburb dropdown styling */
.suburb-dropdown {
    background: white !important;
    color: #333 !important;
    border: 1px solid #ced4da !important;
}

/* Fix dropdown options styling */
.suburb-dropdown option {
    background: white !important;
    color: #333 !important;
    padding: 8px 12px !important;
}

/* For Select2 or similar plugins */
.select2-container--default .select2-results__option {
    background-color: white !important;
    color: #333 !important;
    padding: 8px 12px !important;
}

.select2-container--default .select2-results__option--highlighted {
    background-color: #007bff !important;
    color: white !important;
}

.select2-container--default .select2-selection--single {
    background-color: white !important;
    border: 1px solid #ced4da !important;
    color: #333 !important;
}

.select2-dropdown {
    background-color: white !important;
    border: 1px solid #ced4da !important;
}

/* For custom livesearch styling */
.livesearch-dropdown {
    background: white !important;
    border: 1px solid #ced4da !important;
    max-height: 200px;
    overflow-y: auto;
    z-index: 1050;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.livesearch-dropdown .dropdown-item {
    background: white !important;
    color: #333 !important;
    padding: 8px 16px;
    cursor: pointer;
    border-bottom: 1px solid #eee;
}

.livesearch-dropdown .dropdown-item:hover {
    background: #f8f9fa !important;
    color: #333 !important;
}

.livesearch-dropdown .dropdown-item:active,
.livesearch-dropdown .dropdown-item.active {
    background: #007bff !important;
    color: white !important;
}

/* Fix for dark theme override */
.content-wrapper .form-control {
    background-color: white !important;
    color: #333 !important;
    border: 1px solid #ced4da !important;
}

.content-wrapper .form-control:focus {
    background-color: white !important;
    color: #333 !important;
    border-color: #80bdff !important;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25) !important;
}
  .selectize-dropdown-content{
    background-color: white !important;
  }
  .selectize-input{
    top:-10px;
  }
</style>
<script>
    $(document).ready(function () {
        //$('#country').trigger('change');
    })
</script>
<script>
$(document).ready(function() {  
    
    $('#country').on('change', function() {      
        const selectedOption = $(this).val();
        //const shortname = selectedOption.data('shortname'); // Add data-shortname to your country options
        const suburbLabel = $('#sub_lebel');
        //alert(selectedOption);
        if (selectedOption === '101') {
            suburbLabel.text('City State');
        }else if (selectedOption === '157') {
            suburbLabel.text('City/District, Suburb');
            //$('#sub_lebel').attr('placeholder', 'Suburb');
        }else if (selectedOption === '13') {
            suburbLabel.text('City State/Territory');
            //$('#sub_lebel').attr('placeholder', 'Suburb');
        }else if (selectedOption === '230') {
            suburbLabel.text('Region, County');
            //$('#sub_lebel').attr('placeholder', 'Suburb');
        }else if (selectedOption === '231') {
            suburbLabel.text('City State');
            //$('#sub_lebel').attr('placeholder', 'Suburb');
        }else if (selectedOption === '44') {
            suburbLabel.text('Provinces, Cities');
            //$('#sub_lebel').attr('placeholder', 'Suburb');
        } else {
            suburbLabel.text('City/State');
            //$('#sub_lebel').attr('placeholder', 'City/State');
        }
    });
});
</script>
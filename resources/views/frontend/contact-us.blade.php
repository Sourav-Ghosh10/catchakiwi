@include('includes/inner-header')

<style>
        .error {
            color: red;
        }
        .success {
            color: green;
        }
        .hidden {
            display: none !important;
        }
    </style>
  <div class="mid_body">
    <div class="container">
      <div class="getquote_mid">
        <h2>Contact Us</h2>
        <div class="getquote_frm">
            @if (session('success'))
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                  </div>
                  <div class="modal-body">
                    {{ session('success') }}<br>
                    <br><br>
                    
                    <b>We will get back to you soon</b>
                  </div>
                        <a href="/" class="btn  contctbackcatki">Back to the homepage</a>
                </div>
              </div>
            </div>
                <div>
                    
                </div>
            @endif
          <form action="{{ route('contact-us') }}" method="post" id="contactform">
              @csrf
            <h3>Please Provide Your Contact Details.</h3>
            
            <div class="get_qucontafrm">
              <div class="frm_dv">
                  <div class="row">
                      <div class="col-sm-6">
                        <input name="name" type="text" value="{{ old('name') }}" placeholder="Name *" required>
                        @error('name')
                            <div class="error">{{ $message }}</div>
                        @enderror
                        </div>
                        <div class="col-sm-6">
                            <input name="email" type="email" value="{{ old('email') }}" placeholder="Email *" required>
                            @error('email')
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <select name="country" class="country" id="countries" required>
                                @if(!empty($country))
                                    @foreach($country as $cnty)
                                        <option value="{{$cnty['id']}}" <?= (session('CountryCode')==$cnty['shortname'])?'selected':'' ?>>{{$cnty['name']}}</option>
                                    @endforeach
                                  @endif;
                                <option value="others">Others</option>
                            </select>
                        
                            @error('country')
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>
                    
                
                      <div class="col-sm-6">
                        <select class="livesearch cityid" name="suburb_id" id="cityid" placeholder="Select Location" required>
                              <option value="" disabled selected>Select Location</option>
                        </select>
                        @error('suburb_id')
                            <div class="error">{{ $message }}</div>
                        @enderror
                        
                            <input name="otherscoun" type="text" value="{{ old('otherscoun') }}" placeholder="Country *" class="hidden otherscoun" required>
                        @error('otherscoun')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>

                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <input name="phone_no" type="text" value="{{ old('phone_no') }}" placeholder="Mobile Number ">
                        @error('phone_no')
                            <div class="error">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <textarea name="message" placeholder="Message *" required>{{old('message')}}</textarea>
                        @error('message')
                            <div class="error">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>
                </div>
                <input name="" type="submit" value="submit">
              </div>
              
            <!-- <input name="" type="reset" value="Back"> -->
            
          </form>
        </div>

      </div>
    </div>
  </div>
 @include('includes/footer')

  <script>
  $(document).ready(function () {
      $('#cityid').selectize({
            create: true,
            sortField: 'text',
            render: {
                no_results: function(data, escape) {
                    return '<div class="no-results">No results found</div>';
                }
            }
        });
       
        $('#countries').change(function () {
            var countryId = $(this).val();
                var selectizeInstance = $('#cityid')[0].selectize;
                //console.log(selectizeInstance);return false;
                if (countryId === 'others') {
                    $('.otherscoun').removeClass('hidden');
                    $('.otherscoun').val('');
                    //var selectizeInstance = $select[0].selectize;
                    //selectizeInstance.destroy();
                    $('#cityid').removeAttr('required');
                    selectizeInstance.$control_input.removeAttr('required');
                    $('.cityid').hide();
                }else{
                //alert(countryId);
                $.ajax({
                    url: 'getCitystateforselectsize', // Replace with your backend route to fetch cities
                    method: 'POST',
                    data: {
                        country_id: countryId,
                        _token: $('input[name="_token"]').val()
                    },
                    success: function (response) {
                        console.log(response);
                        $('.otherscoun').addClass('hidden');
                        $('.otherscoun').val('others');
                        $('#cityid').attr('required', 'required');
                        $('.selectize-control').show();
                        //$('.cityid').show();
                        //$('#cityid').html(response);
                        //$('#cityid').prepend('<option value="" selected>Select Location</option>');
                        
                        selectizeInstance.clearOptions();
                        selectizeInstance.addOption(JSON.parse(response));
                        // Refresh the dropdown to display new options
                        selectizeInstance.refreshOptions(false);

                    },
                    error: function (xhr, status, error) {
                        console.error(error);
                    }
                });
            }
        });
         
        $('#countries').trigger('change');
        
    });
//   $(document).ready(function () {
//         $('#countries').change(function () {
//             var countryId = $(this).val();
//                 if (countryId === 'others') {
//                     $('.otherscoun').removeClass('hidden');
//                     $('.otherscoun').val('');
//                     $('.suburb_id').hide();
//                     $('#suburb_id').select2('destroy');
//                 }else{
//                 //alert(countryId);
//                 $.ajax({
//                     url: 'getCityState', // Replace with your backend route to fetch cities
//                     method: 'POST',
//                     data: {
//                         country_id: countryId,
//                         _token: $('input[name="_token"]').val()
//                     },
//                     success: function (response) {
//                         //console.log(response);
//                         $('.otherscoun').addClass('hidden');
//                         $('.otherscoun').val('others');
//                         $('#suburb_id').html(response);
//                         $('#suburb_id').prepend('<option value="" selected>Select Location</option>');
//                         $('#suburb_id').select2({
//                             placeholder: "Select Suburb/Town",
//                             allowClear: false,
//                             minimumResultsForSearch: 0,
//                         });
//                     },
//                     error: function (xhr, status, error) {
//                         console.error(error);
//                     }
//                 });
//             }
//         });
         
//         $('#countries').trigger('change');
//     });
    
    // $(document).ready(function() {
    //     function toggleOtherCountryField() {
    //         //alert('ok');
    //         if ($('.country').val() === 'others') {
    //             $('.otherscoun').removeClass('hidden');
    //             $('.otherscoun').val('');
    //             $('.suburb_id').hide();
    //             $('#suburb_id').select2('destroy');
    //         } else {
    //             $('.otherscoun').addClass('hidden');
    //             $('.otherscoun').val('others');
    //             $('.suburb_id').show();
    //         }
    //     }

    //     toggleOtherCountryField(); // Initial check

    //     $('.country').on('change', function() {
    //         toggleOtherCountryField();
    //     });
    // });
  </script>
 <script>
$(document).ready(function() {
    // Prevent modal from closing when clicking outside
    $('#exampleModal').modal({
        backdrop: 'static',
        keyboard: false
    });

});
</script>
@if (session('success'))
 <script>
 $(document).ready(function() {
    $('#exampleModal').modal('show');
 });
 </script>
@endif


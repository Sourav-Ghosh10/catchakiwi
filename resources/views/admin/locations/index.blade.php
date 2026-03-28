@include('includes/admin-header')
@include('includes/admin-sidebar')
<style>
.modal {
  display: none;
  position: fixed;
  z-index: 999;
  padding-top: 100px;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgb(0,0,0);
  background-color: rgba(0,0,0,0.4);
}

/* Enhanced Modal Content */
.modal-content {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  margin: auto;
  padding: 0;
  border: none;
  border-radius: 15px;
  width: 90%;
  max-width: 500px;
  box-shadow: 0 20px 40px rgba(0,0,0,0.3);
  animation: modalSlideIn 0.3s ease-out;
  overflow: hidden;
}

@keyframes modalSlideIn {
  from {
    transform: translateY(-50px);
    opacity: 0;
  }
  to {
    transform: translateY(0);
    opacity: 1;
  }
}

.modal-header {
  background: rgba(255,255,255,0.1);
  backdrop-filter: blur(10px);
  padding: 20px 25px;
  border-bottom: 1px solid rgba(255,255,255,0.2);
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.modal-title {
  color: white;
  font-size: 18px;
  font-weight: 600;
  margin: 0;
}

.modal-body {
  padding: 25px;
  background: white;
}

.modal-form-group {
  margin-bottom: 20px;
}

.modal-form-group label {
  display: block;
  margin-bottom: 8px;
  color: #333;
  font-weight: 500;
  font-size: 14px;
}

.modal-form-group input[type="text"] {
  width: 100%;
  padding: 12px 15px;
  border: 2px solid #e1e5e9;
  border-radius: 8px;
  font-size: 14px;
  transition: all 0.3s ease;
  box-sizing: border-box;
}

.modal-form-group input[type="text"]:focus {
  outline: none;
  border-color: #667eea;
  box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.modal-actions {
  display: flex;
  gap: 10px;
  justify-content: flex-end;
  margin-top: 25px;
}

.btn-modal-primary {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  border: none;
  padding: 12px 24px;
  border-radius: 8px;
  font-size: 14px;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.3s ease;
  min-width: 100px;
}

.btn-modal-primary:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
}

.btn-modal-secondary {
  background: #6c757d;
  color: white;
  border: none;
  padding: 12px 24px;
  border-radius: 8px;
  font-size: 14px;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.3s ease;
  min-width: 100px;
}

.btn-modal-secondary:hover {
  background: #5a6268;
  transform: translateY(-1px);
}

.close {
  color: rgba(255,255,255,0.8);
  font-size: 19px;
  font-weight: bold;
  cursor: pointer;
  transition: color 0.3s ease;
  background: none;
  border: none;
  padding: 0;
  background-color: #000;
}

.close:hover,
.close:focus {
  color: white;
  text-decoration: none;
}

/* Loading state */
.btn-loading {
  position: relative;
  pointer-events: none;
}

.btn-loading::after {
  content: "";
  position: absolute;
  width: 16px;
  height: 16px;
  margin: auto;
  border: 2px solid transparent;
  border-top-color: #ffffff;
  border-radius: 50%;
  animation: spin 1s linear infinite;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}

@keyframes spin {
  0% { transform: translate(-50%, -50%) rotate(0deg); }
  100% { transform: translate(-50%, -50%) rotate(360deg); }
}

/* Form styling for better UX */
.form-row {
  display: flex;
  gap: 15px;
}

.form-row .modal-form-group {
  flex: 1;
}

.readonly-field {
  background-color: #f8f9fa;
  color: #6c757d;
}

.table-success {
  background-color: #d4edda !important;
  transition: background-color 0.3s ease;
}
</style>

<div class="content-wrapper">
    <div class="container">
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
            <!-- Country Dropdown -->
            <div class="form-group">
                <label for="country">Country</label>
                <select name="country" id="country" class="">
                    <option value="">Select Country</option>
                    @foreach($countries as $country)
                        <option value="{{ $country->id }}" {{ old('country') == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- State Dropdown -->
            <div class="form-group">
                <label for="state">Region</label>
                <select name="state" id="state" class="" disabled>
                    <option value="">Select Region</option>
                </select>
            </div>

            <div class="form-group">
                <label for="city">City / District</label>
                <select name="city" id="city" class="" disabled>
                    <option value="">Select City / District</option>
                </select>
            </div>

            <div class="form-group">
                <label for="town">Suburb / Town</label>
                <select name="town" id="town" class="" disabled>
                    <option value="">Select Suburb / Town</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success locationEdit">Edit Location</button>

            <div class="content-area">
                
            </div>
            
        </div>
    </div>
</div>
<input type="hidden" class="csrf" value="{{ csrf_token() }}">

<!-- Edit Modal -->
<div id="myModal" class="modal">
  <div class="modal-content">
    <div class="modal-header">
      <h4 class="modal-title">Edit Location</h4>
      <button class="close" type="button">&times;</button>
    </div>
    <div class="modal-body">
      <form id="update-form">
        @csrf
        <div class="form-row">
          <div class="modal-form-group">
            <label for="lat">Latitude</label>
            <input type="text" name="lat" id="lat" placeholder="Enter latitude">
          </div>
          <div class="modal-form-group">
            <label for="long">Longitude</label>
            <input type="text" name="long" id="long" placeholder="Enter longitude">
          </div>
        </div>
        
        <div class="modal-form-group">
          <label for="zoomlevel">Zoom Level</label>
          <input type="text" name="zoomlevel" id="zoomlevel" placeholder="Enter zoom level">
        </div>

        <input type="hidden" name="state_id" id="selected-state-id">
        <div class="modal-form-group" id="state-name-group" style="display: none;">
          <label for="selected-state">Region Name</label>
          <input type="text" name="state_name" id="selected-state" placeholder="Enter region name">
        </div>

        <input type="hidden" name="city_id" id="selected-city-id">
        <div class="modal-form-group" id="city-name-group" style="display: none;">
          <label for="selected-city">City Name</label>
          <input type="text" name="city_name" id="selected-city" placeholder="Enter city name">
        </div>

        <input type="hidden" name="town_id" id="selected-town-id">
        <div class="modal-form-group" id="town-name-group" style="display: none;">
          <label for="selected-town">Town Name</label>
          <input type="text" name="town_name" id="selected-town" placeholder="Enter town name">
        </div>

        <div class="modal-actions">
          <button type="button" class="btn-modal-secondary close">Cancel</button>
          <button type="submit" class="btn-modal-primary">Update Location</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Add Modal -->
<div id="myModalAdd" class="modal">
  <div class="modal-content">
    <div class="modal-header">
      <h4 class="modal-title">Add New Location</h4>
      <button class="close" type="button">&times;</button>
    </div>
    <div class="modal-body">
      <form id="add-form">
        @csrf
        <input type="hidden" name="id" id="id">
        <input type="hidden" name="type" id="loctype">
        
        <div class="form-row">
          <div class="modal-form-group">
            <label for="lat-add">Latitude</label>
            <input type="text" name="lat" id="lat-add" placeholder="Enter latitude">
          </div>
          <div class="modal-form-group">
            <label for="long-add">Longitude</label>
            <input type="text" name="long" id="long-add" placeholder="Enter longitude">
          </div>
        </div>
        
        <div class="modal-form-group">
          <label for="zoomlevel-add">Zoom Level</label>
          <input type="text" name="zoomlevel" id="zoomlevel-add" placeholder="Enter zoom level">
        </div>
        
        <div class="modal-form-group">
          <label for="inputdata">Location Name</label>
          <input type="text" name="locname" id="inputdata" placeholder="Enter location name" required>
        </div>

        <div class="modal-actions">
          <button type="button" class="btn-modal-secondary close">Cancel</button>
          <button type="submit" class="btn-modal-primary">Add Location</button>
        </div>
      </form>
    </div>
  </div>
</div>

@include('includes/admin-footer')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    // Handle country change
    $(document).on('change','#country',function () {
        var countryId = $(this).val();
        if (countryId) {
            $('#state').prop('disabled', false);
            $.ajax({
                url: '/admin/locations/get-states/' + countryId,
                type: 'GET',
                success: function (data) {
                    const label = document.querySelector('label[for="state"]');
                    if(countryId==157){
                        var stateOptions = '<option value="">Select Region</option>';
                        label.textContent = 'Region';
                    }else{
                        var stateOptions = '<option value="">Select State</option>';
                        label.textContent = 'State';
                    }
                    var stateHtml = 'Region <button id="addLocation" data-type="state" data-id="'+countryId+'">Add</button><table>';
                    $.each(data, function (index, state) {
                        stateOptions += '<option value="' + state.id + '">' + state.name + '</option>';
                        stateHtml += '<tr><td>Region | </td><td> ' + state.name + ' | </td><td>  Latitude |</td><td>' + (state.lat ? state.lat : "")  + '|</td><td> Longitude |</td><td>' + (state.longitude??"") + '|</td><td> Zoom Level | </td><td>' + (state.zoom_level??"") + '|</td><td><button data-state-id='+state.id+' data-state="'+state.name+'" data-lat="'+state.lat+'" data-long="'+state.longitude+'" data-zoomlevel="'+state.zoom_level+'" class="cityEdit">Edit</button><button data-state-id='+state.id+' data-type="region"  class="cityDelete">Delete</button></td></tr>';    
                    });
                    $('#state').html(stateOptions);
                    stateHtml +="</table>";
                    $('.content-area').html(stateHtml);
                }
            });
        } else {
            $('#state').prop('disabled', true);
            $('#city').prop('disabled', true);
            $('#town').prop('disabled', true);
        }
    });

    // Handle state change
    $('#state').change(function () {
        var stateId = $(this).val();
        var stateName = $(this).find(":selected").text();
        if (stateId) {
            $('#city').prop('disabled', false);
            $.ajax({ 
                url: '/admin/locations/get-cities/' + stateId,
                type: 'GET',
                success: function (data) { 
                    var stateOptions = '<option value="">Select City / District</option>';
                    var cityHtml = 'City / District<button id="addLocation" data-type="city" data-id="'+stateId+'">Add</button><table>';
                    $.each(data, function (index, city) {
                        stateOptions += '<option value="' + city.id + '">' + city.name + '</option>';
                        cityHtml += '<tr><td>City / District | </td><td> ' + city.name + ' | </td><td>  Latitude |</td><td>'+(city.lat??"")+'|</td><td> Longitude |</td><td>'+(city.longitude??"")+'|</td><td> Zoom Level | </td><td>'+(city.zoom_level??"")+'|</td><td><button data-city-id='+city.id+' data-city="'+city.name+'" data-lat="'+city.lat+'" data-long="'+ city.longitude +'" data-zoomlevel="'+ city.zoom_level +'" class="cityEdit">Edit</button><button data-city-id='+city.id+' data-type="city" class="cityDelete">Delete</button></td></tr>';    
                    });
                    cityHtml +="</table>";
                    $('#city').html(stateOptions);
                    $('.content-area').html(cityHtml);
                }
            });
        } else {
            $('#city').prop('disabled', true);
            $('#town').prop('disabled', true);
        }
    });

    // Fixed delete functionality with proper instant update
    $(document).on('click', '.cityDelete', function () {
        if (!confirm("Are you sure you want to delete this record?")) {
            return;
        }

        let deleteBtn = $(this);       // store button reference
        let thisRow   = deleteBtn.closest("tr");

        deleteBtn.prop('disabled', true).text('Deleting...');

        $.ajax({
            url: '/admin/locations/city-delete/',
            type: 'POST',
            data: {
                cityid: deleteBtn.data('city-id'),
                townid: deleteBtn.data('town-id'),
                stateid: deleteBtn.data('state-id'),
                type: deleteBtn.data('type'),
                _token: $('.csrf').val()
            },
            success: function (response) {
                if (response.message) {
                    //alert(response.message);
                    thisRow.fadeOut(300, function () {
                        $(this).remove();
                    });
                } else {
                    alert(response.message || "An error occurred. Please try again.");
                    deleteBtn.prop('disabled', false).text('Delete');
                }
            },
            error: function () {
                alert("Failed to delete. Please try again later.");
                deleteBtn.prop('disabled', false).text('Delete');
            }
        });
    });


    // Fixed edit functionality with better field management
    $(document).on('click','.cityEdit', function(){
        let datastate = $(this).attr('data-state');
        let datastateid = $(this).attr('data-state-id');
        let datacity = $(this).attr('data-city');
        let datacityid = $(this).attr('data-city-id');
        let datatown = $(this).attr('data-town');
        let datatownid = $(this).attr('data-town-id');
        let datalat = $(this).attr('data-lat');
        let datalong = $(this).attr('data-long');
        let datazoomlevel = $(this).attr('data-zoomlevel');
        
        // Store reference to the current row for direct update
        $('#update-form').data('currentRow', $(this).closest('tr'));
        $('#update-form').data('currentButton', $(this));
        
        // Clear and populate form fields
        $("#lat").val(datalat !== "null" && datalat !== "undefined" ? datalat : "");
        $("#long").val(datalong !== "null" && datalong !== "undefined" ? datalong : "");
        $("#zoomlevel").val(datazoomlevel !== "null" && datazoomlevel !== "undefined" ? datazoomlevel : "");
        
        $("#selected-state-id").val(datastateid || "");
        $("#selected-state").val(datastate || "");
        $("#selected-city-id").val(datacityid || "");
        $("#selected-city").val(datacity || "");
        $("#selected-town-id").val(datatownid || "");
        $("#selected-town").val(datatown || "");
        
        // Show/hide relevant fields
        $("#state-name-group").toggle(!!datastateid);
        $("#city-name-group").toggle(!!datacityid);
        $("#town-name-group").toggle(!!datatownid);
        
        $('#myModal').show();
    });

    $(document).on('click','#addLocation', function(){
        let type = $(this).attr("data-type");
        let id = $(this).attr("data-id");
        $("#loctype").val(type); 
        $("#id").val(id); 
        
        // Clear add form
        $("#lat-add, #long-add, #zoomlevel-add, #inputdata").val("");
        
        $('#myModalAdd').show();
    });

    $(document).on('click','.close', function(){
        // Reset all form states when closing
        $('.btn-loading').removeClass('btn-loading').prop('disabled', false);
        $('#update-form button[type="submit"]').text('Update Location');
        $('#add-form button[type="submit"]').text('Add Location');
        
        $('#myModal').hide();
        $('#myModalAdd').hide();
    });

    $('#city').change(function () {
        var cityId = $(this).val();
        if (cityId) {
            $('#town').prop('disabled', false);
            $.ajax({
                url: '/admin/locations/get-towns/' + cityId,
                type: 'GET',
                success: function (data) {
                    var townOptions = '<option value="">Select Suburb / Town</option>';
                    var townHtml = 'Suburb / Town<button id="addLocation" data-type="town" data-id="'+cityId+'">Add</button><table>';
                    $.each(data, function (index, town) {
                        townOptions += "<option value='" + town.id + "' data-alldata='"+ JSON.stringify(town) +"'>" + town.suburb_name + "</option>";
                        townHtml += '<tr><td>Suburb / Town | </td><td> ' + town.suburb_name + ' | </td><td>  Latitude |</td><td>' + (town.lat??"") + '|</td><td> Longitude |</td><td>' + (town.longitude??"") + '|</td><td> Zoom Level | </td><td>' + (town.zoom_level??"") + '|</td><td><button data-town-id='+town.id+' data-town="'+town.suburb_name+'" data-lat="'+town.lat+'" data-long="'+town.longitude+'" data-zoomlevel="'+town.zoom_level+'"  class="cityEdit">Edit</button><button data-town-id='+town.id+' data-type="town"  class="cityDelete">Delete</button></td></tr>';    
                    });
                    $('#town').html(townOptions);
                    townHtml +="</table>"; 
                    $('.content-area').html(townHtml);
                }
            });
        } else {
            $('#town').prop('disabled', true);
        }
    });

    $('#town').change(function () {
        var townId = $(this).val();
        var town = JSON.parse($(this).find(":selected").attr("data-alldata"));
        var townHtml = 'Suburb / Town<button id="addLocation" data-type="town" data-id="'+town.city_id+'">Add</button><table>';
        townHtml += '<tr><td>Suburb / Town | </td><td> ' + town.suburb_name + ' | </td><td>  Latitude |</td><td>' + (town.lat??"") + '|</td><td> Longitude |</td><td>' + (town.longitude??"") + '|</td><td> Zoom Level | </td><td>' + (town.zoom_level??"") + '|</td><td><button data-town-id='+town.id+' data-town="'+town.suburb_name+'" data-lat="'+town.lat+'" data-long="'+town.longitude+'" data-zoomlevel="'+town.zoom_level+'"  class="cityEdit">Edit</button><button data-town-id='+town.id+' data-type="town" class="cityDelete">Delete</button></td></tr>';    
        townHtml +="</table>"; 
        $('.content-area').html(townHtml);
    });

    // Fixed update form submission with instant refresh
    $('#update-form').submit(function (e) {
        e.preventDefault();
        
        let submitBtn = $(this).find('button[type="submit"]');
        let originalText = submitBtn.text();
        
        // Prevent double submission
        if (submitBtn.hasClass('btn-loading')) {
            return false;
        }
        
        // Show loading state
        submitBtn.addClass('btn-loading').prop('disabled', true).text('Updating...');
        
        let stateid = $("#selected-state-id").val();
        let cityid = $("#selected-city-id").val();
        let townid = $("#selected-town-id").val();
        let country = $("#country");
        let countryId = country.val();
        let stateId = $("#state").val();
        let cityIdSelected = $("#city").val();
        
        // Get form data for immediate UI update
        let formData = {
            lat: $("#lat").val(),
            long: $("#long").val(),
            zoomlevel: $("#zoomlevel").val(),
            state_name: $("#selected-state").val(),
            city_name: $("#selected-city").val(),
            town_name: $("#selected-town").val()
        };
        
        $.ajax({
            url: '/admin/locations/update',
            type: 'PUT',
            data: $(this).serialize(),
            success: function (response) {
                //alert(response.message);
                
                // Reset button state FIRST
                submitBtn.removeClass('btn-loading').prop('disabled', false).text(originalText);
                
                // Update the current row immediately with new data
                let currentRow = $('#update-form').data('currentRow');
                let currentButton = $('#update-form').data('currentButton');
                
                if (currentRow && currentRow.length) {
                    // Update the table cells with new values
                    let cells = currentRow.find('td');
                    
                    // Update latitude cell
                    $(cells[2]).text(formData.lat || '');
                    
                    // Update longitude cell  
                    $(cells[4]).text(formData.long || '');
                    
                    // Update zoom level cell
                    $(cells[6]).text(formData.zoomlevel || '');
                    
                    // Update name cell (first cell after the type)
                    if (formData.town_name) {
                        $(cells[1]).text(formData.town_name + ' | ');
                    } else if (formData.city_name) {
                        $(cells[1]).text(formData.city_name + ' | ');
                    } else if (formData.state_name) {
                        $(cells[1]).text(formData.state_name + ' | ');
                    }
                    
                    // Update button attributes with new data
                    if (currentButton && currentButton.length) {
                        currentButton.attr('data-lat', formData.lat);
                        currentButton.attr('data-long', formData.long);
                        currentButton.attr('data-zoomlevel', formData.zoomlevel);
                        
                        if (formData.town_name) {
                            currentButton.attr('data-town', formData.town_name);
                        } else if (formData.city_name) {
                            currentButton.attr('data-city', formData.city_name);
                        } else if (formData.state_name) {
                            currentButton.attr('data-state', formData.state_name);
                        }
                    }
                    
                    // Add visual feedback for the updated row
                    currentRow.addClass('table-success');
                    setTimeout(function() {
                        currentRow.removeClass('table-success');
                    }, 2000);
                }
                
                // Hide modal
                $(".close").trigger("click");
                
                // Also do the background refresh as backup
                setTimeout(function() {
                    if (townid && cityIdSelected) {
                        $("#city").trigger("change");
                    } else if (cityid && stateId) {
                        $("#state").trigger("change");
                    } else if (stateid && countryId) {
                        country.trigger("change");
                    }
                }, 500);
            },
            error: function (error) {
                alert('An error occurred while updating the location.');
                // Reset button state on error
                submitBtn.removeClass('btn-loading').prop('disabled', false).text(originalText);
            },
            complete: function() {
                // Ensure button is always reset regardless of success/error
                submitBtn.removeClass('btn-loading').prop('disabled', false).text(originalText);
            }
        });
    });

    // Fixed add form submission
    $('#add-form').submit(function (e) {
        e.preventDefault();
    
    let submitBtn = $(this).find('button[type="submit"]');
    let originalText = submitBtn.text();

    if (submitBtn.hasClass('btn-loading')) {
        return false;
    }
	let data_type = $(this).attr('data-type');
    submitBtn.addClass('btn-loading').prop('disabled', true).text('Adding...');

    $.ajax({
        url: '/admin/locations/add',
        type: 'PUT',
        data: $(this).serialize(),
        success: function (response) {
            alert(response.message);

            submitBtn.removeClass('btn-loading').prop('disabled', false).text(originalText);
            $(".close").trigger("click");

            if (response.message) { 
                //let newRow = `
                  //  <tr>
                    //    <td>${response.data.type_label} | </td>
                      //  <td>${response.data.name} | </td>
                        //<td>Latitude |</td><td>${response.data.lat ?? ''} |</td>
                       // <td>Longitude |</td><td>${response.data.long ?? ''} |</td>
                     //   <td>Zoom Level |</td><td>${response.data.zoomlevel ?? ''} |</td>
                       // <td>
                         //   <button 
                           //     data-${response.data.type}-id="${response.data.id}"
                             //   data-${response.data.type}="${response.data.name}"
                            //    data-lat="${response.data.lat ?? ''}"
                              //  data-long="${response.data.long ?? ''}"
                              //  data-zoomlevel="${response.data.zoomlevel ?? ''}"
                           //     class="cityEdit">Edit</button>
                         //   <button 
                          //      data-${response.data.type}-id="${response.data.id}" 
                           //     data-type="${response.data.type}" 
                            //    class="cityDelete">Delete</button>
                       // </td>
                 //   </tr>
               // `; 
              	setTimeout(function() {
                    if (data_type=="state") {
                        $("#country").trigger("change");
                    } else if (data_type=="city") {
                        $("#state").trigger("change");
                    } else if (data_type=='town') {
                        $("#town").trigger("change");
                    }
                }, 500);
                $(".content-area table").append(newRow);
            }

            $('#add-form')[0].reset();
        },
        error: function () {
            alert('An error occurred while adding the location.');
            submitBtn.removeClass('btn-loading').prop('disabled', false).text(originalText);
        },
        complete: function () {
            submitBtn.removeClass('btn-loading').prop('disabled', false).text(originalText);
        }
    });
    });

    // Close modal when clicking outside
    $(window).click(function(event) {
        if (event.target.classList.contains('modal')) {
            // Reset all form states when closing
            $('.btn-loading').removeClass('btn-loading').prop('disabled', false);
            $('#update-form button[type="submit"]').text('Update Location');
            $('#add-form button[type="submit"]').text('Add Location');
            
            $('.modal').hide();
        }
    });
});
</script>
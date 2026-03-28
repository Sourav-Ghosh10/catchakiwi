@include('includes/admin-header')
@include('includes/admin-sidebar')
<style>

.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 999; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
  background-color: #fefefe;
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
  width: 80%;
  color: #000;
}

/* The Close Button */
.close {
  color: #aaaaaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
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
<div id="myModal" class="modal">

  <div class="modal-content">
    <span class="close">&times;</span>
    <form style="" id="update-form">
        @csrf
        <input type="text" name="lat" id="lat" Placeholder="Latitude"><br>
        <input type="text" name="long" id="long" Placeholder="Longitude"><br>
        <input type="text" name="zoomlevel" id="zoomlevel" Placeholder="Zoom Level"><br>
        <input type="hidden" name="state_id" id="selected-state-id">
        <input type="text" name="state_name" id="selected-state"><br>
        <input type="hidden" name="city_id" id="selected-city-id">
        <input type="hidden" name="town_id" id="selected-town-id">
        <input type="text" name="city_name" id="selected-city"><br>
        <input type="text" name="town_name" id="selected-town"><br>
        <button type="submit" class="btn btn-primary">Update Location</button>
        <a class="btn btn-info close" style="left: -84%;position: relative;height: 30px;text-align: center;font-size: 16px;">Close</a>
    </form>
  </div>

</div>
<div id="myModalAdd" class="modal">

  <div class="modal-content">
    <span class="close">&times;</span>
    <form style="" id="add-form">
        @csrf
        <input type="hidden" name="id" id="id">
        <input type="text" name="lat" id="lat" Placeholder="Latitude"><br>
        <input type="text" name="long" id="long" Placeholder="Longitude"><br>
        <input type="text" name="zoomlevel" id="zoomlevel" Placeholder="Zoom Level"><br>
        <input type="text" name="locname" id="inputdata" Placeholder="Location Name"><br>
        <input type="hidden" name="type" id="loctype"><br>
        <button type="submit" class="btn btn-primary">Add Location</button>
        <a class="btn btn-info close" style="left: -85%;position: relative;height: 30px;text-align: center;font-size: 16px;">Close</a>
    </form>
  </div>

</div>
@include('includes/admin-footer')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    // Handle country change
    $(document).on('change','#country',function () {
        var countryId = $(this).val();
        //alert(countryId);
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
                        // if(city?.towns?.length){
                        //     city?.towns?.map((val)=>{
                        //         cityOptions += '<tr><td>State Name - '+ stateName +' | </td><td> City name - ' + city.name + ' | </td><td>  Suburb name - '+val.suburb_name+'</td><td><button data-state-id='+stateId+' data-state='+stateName+' data-city='+city.name+' data-town='+val.suburb_name+' data-city-id='+city.id+' data-town-id='+val.id+'  class="cityEdit">Edit</button><button data-town-id='+val.id+'  class="cityDelete">Delete</button></td></tr>';    
                        //     })
                        // }else{
                        //     cityOptions += '<tr><td>State Name - '+ stateName +'</td><td> City name - ' + city.name + '</td><td><button data-state-id='+stateId+' data-state='+stateName+' data-city-id='+city.id+' data-city='+city.name+' class="cityEdit">Edit</button><button data-city-id='+city.id+'  class="cityDelete">Delete</button></td></tr>';
                        // }
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
    // $(document).on('click','.cityDelete', function(){
    //     const result = confirm("Are you sure you want to delete this record?");
    //     let datacityid = $(this).attr('data-city-id');
    //     let datatownid = $(this).attr('data-town-id');
    //     let datastateid = $(this).attr('data-state-id');
    //     let thisrow = $(this);
    //     //alert(datastateid);
    //     let datatype= $(this).attr('data-type');
    //     //alert($('.csrf').val());
    //     if (result) {
    //         $.ajax({ 
    //             url: '/admin/locations/city-delete/',
    //             type: 'POST',
    //             data:{cityid:datacityid,townid:datatownid,stateid:datastateid,type:datatype,_token: $('.csrf').val()},
    //             success: function (data) { 
    //                 alert(data.message);
    //                 thisrow.closest("tr").remove();
    //             }
    //         });
    //     }
    // })
    $(document).on('click', '.cityDelete', function () {
        const result = confirm("Are you sure you want to delete this record?");
        if (result) {
            let datacityid = $(this).attr('data-city-id');
            let datatownid = $(this).attr('data-town-id');
            let datastateid = $(this).attr('data-state-id');
            let datatype = $(this).attr('data-type');
            //let thisrow = $(this).closest("tr");
            $(this).closest('tr').remove(); return false;
            $.ajax({
                url: '/admin/locations/city-delete/',
                type: 'POST',
                data: {
                    cityid: datacityid,
                    townid: datatownid,
                    stateid: datastateid,
                    type: datatype,
                    _token: $('.csrf').val() // Assuming you have a CSRF token in the form
                },
                success: function (response) {
                    // Handle success response
                    if (response.success) {
                        alert(response.message);
                        //thisrow.remove(); // Remove the <tr> element if deletion is successful
                    } else {
                        alert(response.message || "An error occurred. Please try again.");
                    }
                },
                error: function (xhr, status, error) {
                    // Handle error response
                    alert("Failed to delete. Please try again later.");
                    console.error("Error: ", error);
                }
            });
        }
    });

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
        $("#lat").val(datalat!="null"?datalat:"");
        $("#long").val(datalong!="null"?datalong:"");
        $("#zoomlevel").val(datazoomlevel!="null"?datazoomlevel:"");
        
        $("#selected-state-id").val(datastateid);
        $("#selected-state").val(datastate);
        $("#selected-city-id").val(datacityid);
        $("#selected-city").val(datacity);
        $("#selected-town-id").val(datatownid);
        $("#selected-town").val(datatown);
        //console.log(datatownid);
        $("#selected-town").show();
        $("#selected-state").show();
        $("#selected-city").show();
        if(datatownid==undefined){
            $("#selected-town").hide();
        }
        if(datastateid==undefined){
            $("#selected-state").hide();
        }
        if(datacityid==undefined){
            $("#selected-city").hide();
        }
        $('#myModal').show();
    })
    $(document).on('click','#addLocation', function(){
        let type = $(this).attr("data-type");
        //alert(type);
        let id = $(this).attr("data-id");
        $("#loctype").val(type); 
        $("#id").val(id); 
        $('#myModalAdd').show();
        
    })
    $(document).on('click','.close', function(){
        $('#myModal').hide();
        $('#myModalAdd').hide();
    })
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
        //console.log(townName);
        var townHtml = 'Suburb / Town<button id="addLocation" data-type="town" data-id="'+town.city_id+'">Add</button><table>';
        townHtml += '<tr><td>Suburb / Town | </td><td> ' + town.suburb_name + ' | </td><td>  Latitude |</td><td>' + (town.lat??"") + '|</td><td> Longitude |</td><td>' + (town.longitude??"") + '|</td><td> Zoom Level | </td><td>' + (town.zoom_level??"") + '|</td><td><button data-town-id='+town.id+' data-town="'+town.suburb_name+'" data-lat="'+state.lat+'" data-long="'+town.longitude+'" data-zoomlevel="'+town.zoom_level+'"  class="cityEdit">Edit</button><button data-town-id='+town.id+' data-type="town" class="cityDelete">Delete</button></td></tr>';    
        townHtml +="</table>"; 
        $('.content-area').html(townHtml);
    })
    // Handle update form submission
    
    // $(document).on("click",".locationEdit",function(){
    //     $('#selected-country-id').val($('#country').val());
    //     $('#selected-country').val($('#country option:selected').text());
    //     $('#selected-state-id').val($('#state').val());
    //     $('#selected-state').val($('#state option:selected').text());
    //     $('#selected-city-id').val($('#city').val());
    //     $('#selected-city').val($('#city option:selected').text());
    //     $('#selected-town-id').val($('#town').val());
    //     $('#selected-town').val($('#town option:selected').text());
    //     $('#update-form').show();
    // })
    $('#update-form').submit(function (e) {
        e.preventDefault();
        //console.log($(this).serialize())
        let stateid = $("#selected-state-id").val();
        let cityid = $("#selected-city-id").val();
        let townid = $("#selected-town-id").val();
      	let country = $("#country");
        $.ajax({
            url: '/admin/locations/update', // Replace with your actual route
            type: 'PUT',
            data: $(this).serialize(),
            success: function (response) {
                alert(response.message); // Display success message
                console.log(stateid)
              	$(".close").trigger("click");
                if(stateid){                  
                   country.trigger("change");
                  //alert($("#country").val())
                }else if(cityid){
                   $("#state").trigger("change");
                }else if(townid){
                   $("#city").trigger("change");
                }
                
                
            },
            error: function (error) {
                alert('An error occurred while updating the location.');
            }
        });
    });
    $('#add-form').submit(function (e) {
        e.preventDefault();
        //console.log($(this).serialize())
        $.ajax({
            url: '/admin/locations/add', // Replace with your actual route
            type: 'PUT',
            data: $(this).serialize(),
            success: function (response) {
                alert(response.message); // Display success message
                location.reload(); // Reload page or redirect
            },
            error: function (error) {
                alert('An error occurred while updating the location.');
            }
        });
    });
});
</script>

var base_url = "https://catchakiwi.com/";
//registeraton page
// $('#suburb_id').on('change', function(){
// 		//alert(this.value);
// 		var selectedId = this.value;
// 		var _token = $("input[name='_token']").val();
// 		 $.ajax({
//             type: 'POST',
//             url: "ajaxcontroller/district",
//             data:  "_token="+_token+"&suburb_id="+selectedId,
//             dataType: "json",
//             async: false,
//             success: function(resp) { 
//             console.log(resp)       
//               // if(responce['process'] == "success") {  
//               //   // $(".region_name").html();
//               //   // $(".district_name").html();
//               // } else {
//               //   // do nothing 
//               // }
//              	var fields = resp.split('_');
// 				var district_name = fields[0];
// 				var region_name = fields[1];
// 				var outputHtml = '<input id="district_name" type="text" class="block mt-1 w-full district_name" value="'+district_name+'" readonly><input id="region_name" class="block mt-1 w-full region_name" type="text"value="'+region_name+'" readonly>'
//               $('#region_district_dtls').html(outputHtml);
            
//             }
//           });
// });

//Autocomplete box
$(document).ready(function(){
// 	var CSRF_TOKEN = $("input[name='_token']").val();
// 	$('#suburb_search').autocomplete({
// 		source: function(request, response){
// 			//Fetch data
// 			$.ajax({
// 				url: "ajaxcontroller/getsuburbs",
// 				type: "post",
// 				dataType: "json",
// 				data: {
// 					_token: CSRF_TOKEN,
// 					searchterm: request.term
// 				},
// 				success: function(data){
// 					response(data);
// 				}
// 			});
// 		},
// 		select: function(event, ui){
// 			//alert(ui.item.label);
// 			event.preventDefault();
//     		$(this).val(ui.item.label);
// 			$('#suburb_id').val(ui.item.value);

// 		}
// 	});

$('.countryChange').change(function () {
    var countryId = $(this).val();
    //alert(countryId);
    $.ajax({
        url: base_url+'changecountry?country_id='+countryId, // Replace with your backend route to fetch cities
        method: 'GET',
        success: function (response) {
            //console.log(response);
            let currentUrl = window.location.href;
            console.log(currentUrl);
            //window.location.href="";
            if (currentUrl.includes('/business')) {
                window.location.href=base_url+countryId.toLowerCase()+"/business";
            }
        },
        error: function (xhr, status, error) {
            console.error(error);
        }
    });
});
$('#suburb_id').select2({
    placeholder: "Select Suburb/Town",
    allowClear: false,
    minimumResultsForSearch: 0,
    theme: 'bootstrap',
    });
});

<footer class="footer">
            <div class="d-sm-flex justify-content-center justify-content-sm-between">
              <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © bootstrapdash.com 2021</span>
              <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center"> Free <a href="https://www.bootstrapdash.com/bootstrap-admin-template/" target="_blank">Bootstrap admin template</a> from Bootstrapdash.com</span>
            </div>
          </footer>
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    
    <!-- End custom js for this page -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js"></script>

<script>
if ($('#towns_id').length > 0) {
    let country_id = $('#country').val();
    if(country_id == 157){
        $('#towns_id').selectize({ 
            create: true,
            placeholder: 'Select Suburb/Town',
            create: false,
            render: {
                no_results: function(data, escape) {
                    return '<div class="no-results">No results found</div>';
                }
            }
        });
    }else{
        $('#towns_id').selectize({ 
            create: true,
            placeholder: 'Select City/State',
            create: false,
            render: {
                no_results: function(data, escape) {
                    return '<div class="no-results">No results found</div>';
                }
            }
        });
    }
}

$(document).ready(function() {
    if ($('#usersTable').length > 0) {
        $('#usersTable').DataTable({
            "paging": true,         // Enable pagination
            "searching": true,      // Enable search box
            "ordering": true,       // Enable sorting
            "info": true,           // Show table info
            "lengthMenu": [10, 100, 1000],  // Number of rows per page
            "language": {
                "search": "Search Users:",
                "lengthMenu": "Show _MENU_ entries",
                "info": "Showing _START_ to _END_ of _TOTAL_ users"
            }
        });
    }
});
$(document).ready(function () {
    $('#country').change(function () {
        var selectizeInstance = $('#towns_id')[0].selectize;
        var countryId = $(this).val();
        var hiddentownid = $("#hiddentownid").val();
        
        //alert(countryId);
        $.ajax({
            url: '<?= URL('/') ?>/getCityState', 
            method: 'POST',
            data: {
                country_id: countryId,
                _token: $('input[name="_token"]').val()
            },
            success: function (response) {
                console.log(response);
                 
                
                $('.selectize-control').show();
                if (countryId == 157) {
                    selectizeInstance.settings.placeholder = 'Select Suburb/Town';
                } else {
                    selectizeInstance.settings.placeholder = 'Select City/State';
                }
                selectizeInstance.updatePlaceholder();

                selectizeInstance.clearOptions();
                selectizeInstance.addOption(JSON.parse(response));
                selectizeInstance.refreshOptions(false);
                $('#towns_id')[0].selectize.setValue(hiddentownid);

            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    });
    $('#country').trigger('change');
});    
</script>
  </body>
</html>
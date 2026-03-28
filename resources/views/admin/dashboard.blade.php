@include('includes/admin-header')
@include('includes/admin-sidebar')
<div class="main-panel">
  <div class="content-wrapper">
    
    <div class="row">
      <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-9">
                <div class="d-flex align-items-center align-self-start">
                  <h3 class="mb-0">{{$count}}</h3>
                  <p class="text-success ms-2 mb-0 font-weight-medium"></p>
                </div>
              </div>
              <div class="col-3">
                <div class="icon icon-box-success ">
                  <span class="mdi mdi-arrow-top-right icon-item"></span>
                </div>
              </div>
            </div>
            <h6 class="text-muted font-weight-normal">Total Users</h6>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-9">
                <div class="d-flex align-items-center align-self-start">
                  <h3 class="mb-0">{{$articleStats['total']}}</h3>
                </div>
              </div>
              <div class="col-3">
                <div class="icon icon-box-primary">
                  <span class="mdi mdi-file-document icon-item"></span>
                </div>
              </div>
            </div>
            <h6 class="text-muted font-weight-normal">Total Articles</h6>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-9">
                <div class="d-flex align-items-center align-self-start">
                  <h3 class="mb-0">{{$articleStats['published']}}</h3>
                </div>
              </div>
              <div class="col-3">
                <div class="icon icon-box-success">
                  <span class="mdi mdi-check-circle icon-item"></span>
                </div>
              </div>
            </div>
            <h6 class="text-muted font-weight-normal">Published Articles</h6>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-9">
                <div class="d-flex align-items-center align-self-start">
                  <h3 class="mb-0">{{$articleStats['total_views']}}</h3>
                </div>
              </div>
              <div class="col-3">
                <div class="icon icon-box-info">
                  <span class="mdi mdi-eye icon-item"></span>
                </div>
              </div>
            </div>
            <h6 class="text-muted font-weight-normal">Total Article Views</h6>
          </div>
        </div>
      </div>
    </div>
      <div class="row">    
        <div class="col-lg-4 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Last Login Users</h4>
              </p>
              <div class="table-responsive">
                <table id="usersTableds" class="table table-dark">
                  <thead>
                    <tr>
                      <th> # </th>
                      <th> Name </th>
                      <th> State/Region </th>
                      <th> City/District </th>
                      <th> Registration IP </th>
                      <th> Registration Country </th>
                      <th> User Email </th>
                      <th> Last Login IP </th>
                      <th> Last Login Date & Time </th>
                    </tr>
                  </thead>
                  <tbody>
                    @php $i = 0; @endphp
                    @foreach($users as $usr)
                    <tr>      
                      <td> {{ ++$i }} </td>
                      <td> {{ $usr->name }} </td>
                      <td> {{ $usr->state }} </td>
                      <td> {{ $usr->city }} </td>
                      <td> {{ $usr->ip }} </td> 
                      <td> {{ $usr->country_name }} </td>
                      <td> {{ $usr->email }} </td>
                      <td> {{ $usr->last_login_ip }} </td>
                      <td> {{ $usr->last_login_at }} </td>
                      
                    </tr>   
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      <div class="col-lg-4 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Country-wise Members</h4>
              <div class="table-responsive">
                <table id="countryMembersTable" class="table table-dark">
                  <thead>
                    <tr>
                      <th> # </th>
                      <th> Country Name </th>
                      <th> Country Code </th>
                      <th> Total Members </th>
                      <th> Percentage </th>
                    </tr>
                  </thead>
                  <tbody>
                    @php 
                      $i = 0; 
                      $totalUsers = $membersByCountry->sum('total_members');
                    @endphp
                    @foreach($membersByCountry as $country)
                    <tr>      
                      <td> {{ ++$i }} </td>
                      <td> {{ $country->country_name }} </td>
                      <td> {{ $country->country_code }} </td>
                      <td> {{ number_format($country->total_members) }} </td>
                      <td> 
                        @if($totalUsers > 0)
                          {{ number_format(($country->total_members / $totalUsers) * 100, 1) }}%
                        @else
                          0%
                        @endif
                      </td>
                    </tr>   
                    @endforeach
                    @if($membersByCountry->isEmpty())
                    <tr>
                      <td colspan="5" class="text-center">No data available</td>
                    </tr>
                    @endif
                  </tbody>
                  <tfoot>
                    <tr>
                      <th colspan="3">Total</th>
                      <th>{{ number_format($membersByCountry->sum('total_members')) }}</th>
                      <th>100%</th>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>
        </div>
    
      	<div class="col-lg-4 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title">Total Businesses by Country</h4>
                <div class="table-responsive">
                  <table id="businessesTableds" class="table table-dark">
                    <thead>
                      <tr>
                        <th> # </th>
                        <th> Country Name </th>
                        <th> Country Code </th>
                        <th> Total Businesses </th>
                        <th> Percentage </th>
                      </tr>
                    </thead>
                    <tbody>
                      @php 
                        $i = 0; 
                        $totalBusinesses = $getBusinessesByCountry->sum('total_businesses');
                      @endphp
                      @foreach($getBusinessesByCountry as $country)
                      <tr>      
                        <td> {{ ++$i }} </td>
                        <td> {{ $country->country_name }} </td>
                        <td> {{ $country->country_code }} </td>
                        <td> {{ number_format($country->total_businesses) }} </td>
                        <td> 
                          @if($totalBusinesses > 0)
                            {{ number_format(($country->total_businesses / $totalBusinesses) * 100, 1) }}%
                          @else
                            0%
                          @endif
                        </td>
                      </tr>   
                      @endforeach
                      @if($getBusinessesByCountry->isEmpty())
                      <tr>
                        <td colspan="5" class="text-center">No businesses found</td>
                      </tr>
                      @endif
                    </tbody>
                    <tfoot>
                      <tr>
                        <th colspan="3">Total</th>
                        <th>{{ number_format($getBusinessesByCountry->sum('total_businesses')) }}</th>
                        <th>100%</th>
                      </tr>
                    </tfoot>
                  </table>
                </div>
              </div>
            </div>
          </div>
      </div>
      
    </div>       
   
    
    
  </div>
@include('includes/admin-footer')
<script>
  $('#usersTableds').DataTable({
    paging: false,        // hides pagination (Previous / Next / numbers)
    lengthChange: false,  // hides "Show entries" dropdown
    searching: false,      // keep search box (optional)
    info: false           // hides "Showing 1 to X of X entries"
});
</script>
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
                      <table class="table table-dark">
                        <thead>
                          <tr>
                            <th> # </th>
                            <th> Name </th>
                            <th> Email </th>
                            <th> Country </th>
                            <th> IP </th>
                            <th> Agent </th>
                            <th> Create Date </th>
                          </tr>
                        </thead>
                        <tbody>
                            @php $i = 0; @endphp
                            @foreach($users as $usr)
                          <tr>
                            <td> {{ ++$i }} </td>
                            <td> {{ $usr->name }} </td>
                            <td> {{ $usr->email }} </td>
                            <td> {{ $usr->country_name }} </td>
                            <td> {{ $usr->ip }} </td>
                            <td> {{ $usr->agent }} </td>
                            <td> {{ $usr->created_at }} </td>
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
@include('includes/admin-footer')
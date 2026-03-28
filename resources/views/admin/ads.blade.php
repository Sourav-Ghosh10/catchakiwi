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
                    <h4 class="card-title">Ads Details</h4>
                    </p>
                    <div class="table-responsive">
                      <table class="table table-dark">
                        <thead>
                          <tr>
                            <th> # </th>
                            <th> Ads Image </th>
                            <th> Country </th>
                            <th> Type </th>
                            <th> Action </th>
                          </tr>
                        </thead>
                        <tbody>
                            @php $i = 0; @endphp
                            @foreach($ads as $ad)
                          <tr>
                            <td> {{ ++$i }} </td>
                            <td>@if($ad->ads_image!="") <img src="{{ asset( $ad->ads_image ) }}" style="width: 106px;    height: 106px;     border-radius: 0;"> @endif </td>
                            <td> {{ $ad->country }} </td>
                            <td> {{ $ad->type }} </td>
                            <td> <a class="nav-link" href="{{ route('admin.ads.edit', $ad->id) }}">Edit</a> </td>
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
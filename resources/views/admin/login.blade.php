<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Catchakiwi Admin</title>
    
    <link rel="stylesheet" href="{{ asset('assets/admin/css/style.css') }}">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="../../assets/images/favicon.png" />
  </head> 
  <body>
    <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="row w-100 m-0">
          <div class="content-wrapper full-page-wrapper d-flex align-items-center auth login-bg">
            <div class="card col-lg-4 mx-auto">
              <div class="card-body px-5 py-5">
                <h3 class="card-title text-left mb-3">Login</h3>
                <form method="POST" action="{{ route('admin.login.submit') }}"> 
                    @csrf
                  <div class="form-group">
                    <label>email *</label>
                    <input type="email" name="email" class="form-control p_input">
                    
                  </div>
                  <div class="form-group">
                    <label>Password *</label>
                    <input type="password" name="password" class="form-control p_input">
                  </div>
                  <div class="form-group d-flex align-items-center justify-content-between">
                    
                    <!-- <a href="#" class="forgot-pass">Forgot password</a> -->
                  </div>
                  <div class="text-center">
                    <input type="submit" class="btn btn-primary btn-block enter-btn" value="Login">
                  </div>
                  
                </form>
              </div>
            </div>
          </div>
          <!-- content-wrapper ends -->
        </div>
        <!-- row ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    
  </body>
</html>
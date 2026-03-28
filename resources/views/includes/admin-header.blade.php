<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Dashboard</title>
    
    <link rel="stylesheet" href="{{ asset('assets/admin/css/style.css') }}">
    <!-- End layout styles -->
    <!--<link rel="shortcut icon" href="assets/images/favicon.png" />-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.default.min.css">

<!-- jQuery (Required for DataTables) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- DataTables JS -->

  </head>
  <body>
    <div class="container-scroller">
      
      <!-- partial:partials/_sidebar.html -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
          <a class="sidebar-brand brand-logo" href="#"><img src="{{ asset('assets/images/logo.png') }}" alt="logo" /></a>
          <a class="sidebar-brand brand-logo-mini" href="#"><img src="{{ asset('assets/images/logo.png') }}" alt="logo" /></a>
        </div>
        <ul class="nav">
          <li class="nav-item profile">
            <div class="profile-desc">
              <div class="profile-pic">
                <div class="count-indicator">
                  <img class="img-xs rounded-circle " src="{{ asset('assets/images/andray_pic.png') }}" alt="">
                  <span class="count bg-success"></span>
                </div>
                <div class="profile-name">
                  <h5 class="mb-0 font-weight-normal">Andray</h5>
                  <span></span>
                </div>
              </div>
              <a href="#" id="profile-dropdown" data-bs-toggle="dropdown"><i class="mdi mdi-dots-vertical"></i></a>
              
            </div>
          </li>
          <li class="nav-item nav-category">
            <span class="nav-link">Navigation</span>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="{{ route('admin.dashboard') }}">
              <span class="menu-icon">
                <i class="mdi mdi-speedometer"></i>
              </span>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="{{ route('admin.userlist') }}">
              <span class="menu-icon">
                <i class="mdi mdi-account-group"></i>
              </span>
              <span class="menu-title">User List</span>
            </a>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="{{ route('admin.ads.index') }}">
              <span class="menu-icon">
                <i class="mdi mdi-bullhorn"></i>
              </span>
              <span class="menu-title">Ads</span>
            </a>
          </li>
          <li class="nav-item menu-items" style="border-bottom: 1px solid #2c2e33; margin-bottom: 20px; padding-bottom: 10px;">
            <a class="nav-link" href="{{ route('admin.locations.index') }}">
              <span class="menu-icon">
                <i class="mdi mdi-map-marker-radius"></i>
              </span>
              <span class="menu-title">Location</span>
            </a>
          </li>

          <li class="nav-item nav-category">
            <span class="nav-link">Business Management</span>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="{{ route('admin.businesses.index') }}">
              <span class="menu-icon">
                <i class="mdi mdi-briefcase"></i>
              </span>
              <span class="menu-title">Business List</span>
            </a>
          </li>
          <li class="nav-item menu-items" style="border-bottom: 1px solid #2c2e33; margin-bottom: 20px; padding-bottom: 10px;">
            <a class="nav-link" href="{{ route('admin.categories.index') }}">
              <span class="menu-icon">
                <i class="mdi mdi-format-list-bulleted-type"></i>
              </span>
              <span class="menu-title">Business Categories</span>
            </a>
          </li>

          <li class="nav-item nav-category">
            <span class="nav-link">Article Management</span>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="{{ route('admin.articles.index') }}">
              <span class="menu-icon">
                <i class="mdi mdi-file-document"></i>
              </span>
              <span class="menu-title">Articles</span>
            </a>
          </li>
          <li class="nav-item menu-items" style="border-bottom: 1px solid #2c2e33; margin-bottom: 20px; padding-bottom: 10px;">
            <a class="nav-link" href="{{ route('admin.article-categories.index') }}">
              <span class="menu-icon">
                <i class="mdi mdi-file-document-edit"></i>
              </span>
              <span class="menu-title">Article Categories</span>
            </a>
          </li>

          <li class="nav-item nav-category">
            <span class="nav-link">System</span>
          </li>
          <li class="nav-item menu-items">
              <a class="nav-link" href="{{ route('admin.email-change-requests') }}">
                <span class="menu-icon">
                  <i class="mdi mdi-email-sync"></i>
                </span>
                <span class="menu-title">Email Change Request</span>
              </a>
          </li>
          <li class="nav-item menu-items">
              <a class="nav-link" href="{{ route('admin.notifications.index') }}">
                <span class="menu-icon">
                  <i class="mdi mdi-bell-ring"></i>
                </span>
                <span class="menu-title">Notification List</span>
              </a>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="{{ route('logout') }}">
              <span class="menu-icon">
                <i class="mdi mdi-logout"></i>
              </span>
              <span class="menu-title">Log out</span>
            </a>
          </li>
          <!-- <li class="nav-item menu-items">
            <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
              <span class="menu-icon">
                <i class="mdi mdi-laptop"></i>
              </span>
              <span class="menu-title">Basic UI Elements</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="pages/ui-features/buttons.html">Buttons</a></li>
              </ul>
            </div>
          </li> -->
          
          
          
          
          
        </ul>
      </nav>
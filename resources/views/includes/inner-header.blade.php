@include('includes/header')

   <div class="top_bar inner">
      <!-- Header start-->
         <div class="container">
            <div class="row align-items-center">
               <div class="col-lg-9 col-md-8 col-6 top_menu_col top_menu">
                  @include('includes/topmenu')
                  @include('includes/sidemenu')
               </div>
               <div class="col-lg-3 col-md-4 col-6 nz_region_col text-right">
                  <p class="nz_region mb-0">
                      <select class="countryChange"> 
                            <option value="IN" {{ (session('CountryCode')=="IN")?"selected":"" }}>IN-India</option>
                            <option value="NZ" {{ (session('CountryCode')=="NZ")?"selected":"" }}>NZ-New Zealand</option>
                            <option value="AU" {{ (session('CountryCode')=="AU")?"selected":"" }}>AU-Australia</option>
                            <option value="CN" {{ (session('CountryCode')=="CN")?"selected":"" }}>CN-China</option>
                            <option value="UK" {{ (session('CountryCode')=="UK")?"selected":"" }}>UK-United Kingdom</option>
                            <option value="US" {{ (session('CountryCode')=="US")?"selected":"" }}>US-United States</option>
                        </select>
                  </p>
               </div>
            </div>
         </div>
     </div>

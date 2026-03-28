@include('includes/inner-header')

<div class="top_search nomob_search">
<div class="container"><div class="logo"><h1><a href="/"><img src="{{ asset('assets/images/logo-inner.png') }}" alt="" /></a></h1></div></div>
<div class="container">
<div class="home_midbody">
<div class="home_searchsec">
<form action="" method="post">
<input name="" type="text" placeholder="Services I’m looking for" />
<input name="" type="text" placeholder="Enter your location" class="location" />
<input name="" type="submit" value="Search" />
</form>
</div>
</div>
</div></div>
<!-- Header start end-->

<!-- body start-->
<div class="mid_body">
<div class="container">
<div class="getquote_mid">
<h2>We have people ready to help you 
<span>We understand that these are uncertain times, and the safety of our consumers and tradies is of greatest importance. Before your job starts, ensure you and your tradie are both agreed on the recommended safety measures you will both take. And if you or anyone in your household is feeling unwell, consider posting the job at a later date.</span></h2>
<div class="getquote_frm">
<form action="" method="post">
<h3>I'm Looking for</h3>
<div class="frm_dv">
<select name="">
<option>Handy person</option>
</select>
</div>
<h3>Where do you need the job done?</h3>
<div class="frm_dv">
<select name="">
<option>Towns/Suburbs</option>
</select>
</div>
<h3>When do you need the work to start? </h3>
<div class="frm_dv">
<select name="">
<option>Emergency</option>
</select>
</div>
<h3>Budget</h3>
<div class="frm_dv">
<select name="">
<option>Under $300</option>
</select>
</div>
<h3>Provide a description of your job</h3>
<img src="{{ asset('assets/images/editor_image.png') }}" alt="" class="editorpic">
<div class="frm_dv">
 <label>Image preview</label>
 <div class="frm_dv browse_img">
<div class="custom_browse"> <input id="uploadFile" placeholder="Choose your free image" disabled="disabled" />
<label  class="custom-file-input" >
<input type="file" id="uploadBtn">
</label>
<span>Recommended size 640w/480px ( JPG,GIF,PNG )	</span>
</div>
 </div>
 <div class="imageprvsec">
<ul>
 <li><img src="images/demopic1.png" alt=""><span>X</span></li>
 <li><img src="images/demopic2.png" alt=""><span>X</span></li>
 <li><img src="images/demopic3.png" alt=""><span>X</span></li>
</ul>
 </div>
 </div>
<h3>Please provide contact details so they can contact you</h3>
<div class="get_qucontafrm">
<div class="frm_dv">
<input name="" type="text" value="" placeholder="Name">
<input name="" type="text" value="" placeholder="Email">
</div>
<div class="frm_dv">
<input name="" type="text" value="" placeholder="Mobile Number">
</div>
</div>
<input name="" type="reset" value="Back">
<input name="" type="submit" value="submit">
</form>
</div>

</div>
</div>
</div>
@include('includes/footer')
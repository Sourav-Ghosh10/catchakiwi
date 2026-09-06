@include('includes/header')
<div class="popup_outer" style="display: none">
      <div class="popup_inner bg-white position-relative">
        <button type="button" class="popup_close">
          <i class="fa fa-close"></i>
        </button>
        <div class="d-flex align-items-start h-100 justify-content-start popup">
          <div class="h-100 p-2 sidebar_cover d-flex flex-column align-items-start">
            <div class="sidebar w-100">
              <div class="logo_cover d-flex align-items-center justify-content-center pb-1">
                <img src="images/logo.png" class="w-100" alt="logo" />
              </div>
            </div>
            <div class="sidebar_navigation w-100 flex-1 h-100">
              <ul class="ps-0 mb-0 h-100 flex-1">
                <li><a href="#" data-section="happening" class="active">What's happening</a></li>
                <li><a href="#" data-section="info">Info</a></li>
                <li><a href="#" data-section="features">New Features</a></li>
                <li><a href="#" data-section="faq">FAQ</a></li>
                <li><a href="#" data-section="contact">Contact</a></li>
                <li><a href="#" data-section="sponsors">Sponsors</a></li>
              </ul>
            </div>
            <button type="button" class="popup_close">
              <i class="fa fa-close"></i>
            </button>
          </div>
          <div class="sections pe-2 h-100">
            <div class="section w-100 active" id="happening">
              <h3 class="text-bold mb-3" style="font-size: 30px; line-height: 35px;">The new Catchakiwi is coming</h3>
                <p>It's a pleasure to have you here at Catchakiwi. We are currently having a makeover to better suit you. We're updating to a modernised and user-friendly interface to bring a more enjoyable browsing experience. Our team is working hard to get Catchakiwi feature-rich and looking great.</p>
                <p>Leave us your email address using the form below to keep informed on the progress of the website and get the chance to become one of the first users of the new site.</p>
                <p><a href="https://www.facebook.com/catchakiwinz" target="_blank" class="text-bold text-secondary">Like us on Facebook</a> and <a href="https://twitter.com/catchakiwi" target="_blank" class="text-bold text-secondary">follow us on Twitter </a> to get exclusive information on the project!</p>
                <hr />
                <p class="mt-3">Get updates and get the chance to become one of the first to try the new Catchakiwi</p>
                <!-- First Form -->
                <form action="notification.php" method="post" id="firstForm">
                    <div class="form-row d-flex flex-wrap flex-column flex-md-row">
                        <div class="form-group col-md-4 px-1 mt-2">
                            <input type="text" class="form-control" name="popup_name" placeholder="Name" required>
                        </div>
                        <div class="form-group col-md-4 px-1 mt-2">
                            <input type="email" class="form-control" name="popup_email" placeholder="Email" required>
                        </div>
                        <div class="form-group col-md-4 px-1 mt-2">
                            <input type="submit" id="notify" class="w-100 w-sm-auto form-control popup_notify_submit" value="Notify me" />
                        </div>
                    </div>
                    <div id="form-messages"></div> <!-- To display success or error messages -->
                </form>
                <!-- Your Loading Spinner -->
                <div id="loader" class="catchakiwi-indicator-box">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="-200 -200 400 400"><defs><g id="p"><path fill="#5A9E16" d="M201.937,487.923c-11.376,10.978-22.025,21.262-32.684,31.537    c-16.313,15.73-32.348,31.766-49.032,47.092c-15.788,14.502-34.297,19.106-55.096,12.339c-7.403-2.409-13-7.348-17.926-13.108    c-12.81-14.984-21.973-43.985-6.071-67.953c5.099-7.684,12.125-14.123,18.493-20.923    c47.277-50.472,94.588-100.912,141.936-151.317c22.133-23.563,44.372-47.028,66.56-70.54c2.03-2.151,4.039-4.325,6.239-6.684    c-31.146-29.453-48.097-64.577-44.309-107.688c2.872-32.675,16.659-60.595,40.99-82.71c49.394-44.896,125.431-43.66,173.646,1.955    c47.171,44.627,57.522,129.345-3.045,186.439c5.735,6.17,11.458,12.375,17.231,18.531    c59.959,63.933,119.925,127.858,179.889,191.786c11.398,12.152,23.141,24.004,34.092,36.547    c10.376,11.884,13.214,26.399,10.936,41.688c-1.665,11.173-6.101,21.429-13.376,30.29c-14.19,17.285-38.378,22.285-59.234,10.803    c-8.873-4.886-16.726-12.015-24.155-19.061c-22.729-21.556-45.028-43.566-67.496-65.399c-0.597-0.58-1.182-1.176-1.811-1.721    c-4.393-3.81-7.46-2.812-8.577,2.836c-4.041,20.423-7.961,40.869-12.098,61.272c-13.832,68.226-27.8,136.425-41.598,204.657    c-13.657,67.54-27.145,135.113-40.771,202.659c-3.17,15.712-8.452,30.546-19.943,42.317    c-26.373,27.016-71.095,19.325-88.383-14.892c-7.115-14.082-9.551-29.319-12.582-44.485    c-11.973-59.914-24.045-119.809-36.052-179.716c-18.166-90.642-36.307-181.287-54.472-271.928    C202.985,491.287,202.545,490.064,201.937,487.923z" /></g></defs><g transform="rotate(0) translate(0,-112)" class="person" data-person="0"><g transform="scale(0.045) translate(-358,-520)"><use href="#p" xlink:href="#p" /></g></g><g transform="rotate(45) translate(0,-112)" class="person" data-person="1"><g transform="scale(0.045) translate(-358,-520)"><use href="#p" xlink:href="#p" /></g></g><g transform="rotate(90) translate(0,-112)" class="person" data-person="2"><g transform="scale(0.045) translate(-358,-520)"><use href="#p" xlink:href="#p" /></g></g><g transform="rotate(135) translate(0,-112)" class="person" data-person="3"><g transform="scale(0.045) translate(-358,-520)"><use href="#p" xlink:href="#p" /></g></g><g transform="rotate(180) translate(0,-112)" class="person" data-person="4"><g transform="scale(0.045) translate(-358,-520)"><use href="#p" xlink:href="#p" /></g></g><g transform="rotate(225) translate(0,-112)" class="person" data-person="5"><g transform="scale(0.045) translate(-358,-520)"><use href="#p" xlink:href="#p" /></g></g><g transform="rotate(270) translate(0,-112)" class="person" data-person="6"><g transform="scale(0.045) translate(-358,-520)"><use href="#p" xlink:href="#p" /></g></g><g transform="rotate(315) translate(0,-112)" class="person" data-person="7"><g transform="scale(0.045) translate(-358,-520)"><use href="#p" xlink:href="#p" /></g></g></svg>
                </div>
                <div class="mt-3 row align-items-start flex-row flex-wrap">
                  <div class="col-12 col-sm-6 mt-3 text-center">
                    <div class="d-flex align-items-center justify-content-center position-relative happening_image_section">
                      <img src="images/popup-image-1.png" style="object-fit: contain; max-width: 300px; aspect-ratio: 3/2; width: 100%;" alt="image" />
                      <div class="image_popup">
                        <button type="button" class="image_popup_close">
                          <i class="fa fa-close"></i>
                        </button>
                        <img src="images/popup-image-1.png" style="object-fit: contain; max-width: 300px; aspect-ratio: 3/2; width: 100%;" alt="image" />
                      </div>
                    </div>
                  </div>
                  <div class="col-12 col-sm-6 mt-3 text-center">
                    <div class="d-flex align-items-center justify-content-center position-relative happening_image_section">
                      <img src="images/popup-image-2.png" style="object-fit: contain; max-width: 300px; aspect-ratio: 3/2; width: 100%;" alt="image" />
                      <div class="image_popup">
                        <button type="button" class="image_popup_close">
                          <i class="fa fa-close"></i>
                        </button>
                        <img src="images/popup-image-2.png" style="object-fit: contain; max-width: 300px; aspect-ratio: 3/2; width: 100%;" alt="image" />
                      </div>
                    </div>
                  </div>
                  <div class="col-12 col-sm-6 mt-3 text-center">
                    <div class="d-flex align-items-center justify-content-center position-relative happening_image_section">
                      <img src="images/popup-image-1.png" style="object-fit: contain; max-width: 300px; aspect-ratio: 3/2; width: 100%;" alt="image" />
                      <div class="image_popup">
                        <button type="button" class="image_popup_close">
                          <i class="fa fa-close"></i>
                        </button>
                        <img src="images/popup-image-1.png" style="object-fit: contain; max-width: 300px; aspect-ratio: 3/2; width: 100%;" alt="image" />
                      </div>
                    </div>
                  </div>
                  <div class="col-12 col-sm-6 mt-3 text-center">
                    <div class="d-flex align-items-center justify-content-center position-relative happening_image_section">
                      <img src="images/popup-image-2.png" style="object-fit: contain; max-width: 300px; aspect-ratio: 3/2; width: 100%;" alt="image" />
                      <div class="image_popup">
                        <button type="button" class="image_popup_close">
                          <i class="fa fa-close"></i>
                        </button>
                        <img src="images/popup-image-2.png" style="object-fit: contain; max-width: 300px; aspect-ratio: 3/2; width: 100%;" alt="image" />
                      </div>
                    </div>
                  </div>
                  <div class="col-12 col-sm-6 mt-3 text-center">
                    <div class="d-flex align-items-center justify-content-center position-relative happening_image_section">
                      <img src="images/popup-image-1.png" style="object-fit: contain; max-width: 300px; aspect-ratio: 3/2; width: 100%;" alt="image" />
                      <div class="image_popup">
                        <button type="button" class="image_popup_close">
                          <i class="fa fa-close"></i>
                        </button>
                        <img src="images/popup-image-1.png" style="object-fit: contain; max-width: 300px; aspect-ratio: 3/2; width: 100%;" alt="image" />
                      </div>
                    </div>
                  </div>
                  <div class="col-12 col-sm-6 mt-3 text-center">
                    <div class="d-flex align-items-center justify-content-center position-relative happening_image_section">
                      <img src="images/popup-image-2.png" style="object-fit: contain; max-width: 300px; aspect-ratio: 3/2; width: 100%;" alt="image" />
                      <div class="image_popup">
                        <button type="button" class="image_popup_close">
                          <i class="fa fa-close"></i>
                        </button>
                        <img src="images/popup-image-2.png" style="object-fit: contain; max-width: 300px; aspect-ratio: 3/2; width: 100%;" alt="image" />
                      </div>
                    </div>
                  </div>
                </div>
            </div>
            <div class="section w-100" id="info">
              <h3 class="text-bold mb-3" style="font-size: 30px; line-height: 35px;">What is Catchakiwi?</h3>
              <p>You've seen them in the mall, those crowded corkboards with a patchwork of handwritten ads: "babysitter available", "handcrafted quilts for sale", "for all your gardening needs, call Nigel"…</p>

              <p>From the beginning of time people with goods and services to sell have been trying to connect with people who need those things.</p>

              <p>Now there is a better way.</p>
              <p>Catchakiwi is the modern equivalent of a community noticeboard, an online forum where ordinary Kiwis with skills and services to offer can connect with an endless supply of fellow-Kiwis who need those things.</p>

              <p>Catchakiwi is about tapping into community resources, bringing seekers and sellers together and forming fruitful relationships that strengthen and sustain communities.</p>

              <p>Being self employed has never been easier. Catchakiwi could be your portal to prosperity.</p>
            </div>
            <div class="section w-100" id="features">
              <h3 class="text-bold mb-3" style="font-size: 30px; line-height: 35px;">What's changing at Catchakiwi?</h3>
              <p>Below is just a small amount of the many features you can look forward to seeing in the upcoming release of Catchakiwi</p>
              <p><span class="text-semibold">Seach-Optimisation:</span> Your searches will bring up the results you're looking for. Adding features like Location and Category will allow you to find the service you're looking for, faster than ever.</p>
              <p><span class="text-semibold">Category based emails:</span> As a registered user, you will now be able to subscribe to specific categories. You will be notified when there are any local new service providers in a category you have selected.</p>
              <p><span class="text-semibold">Maps integration:</span> If the service provider allows it, as a registered user you will be able to view the address of the service provider on a map on their profile or on a noticeboard.</p>
              <p><span class="text-semibold">Advertising Cleanup:</span> We don't appreciate being inundated with advertising popups as we click through a page, and we don't imagine that you do either. We're doing an overhaul on our advertising setup. You will only see ads that interest you for services in your area.</p>
              <p><span class="text-semibold">Social Media Integration:</span>Catchakiwi will be on the forefront of social media integration. Login with your Facebook, tweet your favourite service provider. The choice is yours.</p>
              <p><span class="text-semibold">Do more, with less:</span>You will be able to browse more of Catchakiwi without needing to logon. A larger audience will be able to view your profile without requiring a login</p>
              <p><span class="text-semibold">And many more...</span>There are so many more features that we're thinking up every day. We just can't wait to bring them all to you. Ideas also keep flying in from you, and we urge you to keep them coming. If you have anything you'd like to see in the upcoming release of Catchakiwi, let us know on our facebook page, or tweet us, or email us using the contact section of this website. One of the main strategies and benefits of Catchakiwi is collaboration. In that spirit, we are so enthusiastic to include collaborating with you in the creation the new Catchakiwi.</p>
            </div>
            <div class="section w-100" id="faq">
              <h3 class="text-bold" style="font-size: 30px; line-height: 35px;">Frequently Asked Questions</h3>
              <div class="accordion" id="accordionExample">
                <div class="accordion-item open">
                  <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                      How can we be contacted about when Catchakiwi will be ready?
                    </button>
                  </h2>
                  <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                      Like us on Facebook or follow us on Twitter for exclusive information and offers. If you're only interested in the launch date, let us know by filling out the Contact section of this website.
                    </div>
                  </div>
                </div>
                <div class="accordion-item">
                  <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                      How can we be contacted about when Catchakiwi will be ready?
                    </button>
                  </h2>
                  <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                      Like us on Facebook or follow us on Twitter for exclusive information and offers. If you're only interested in the launch date, let us know by filling out the Contact section of this website.
                    </div>
                  </div>
                </div>
                <div class="accordion-item">
                  <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                      How can we be contacted about when Catchakiwi will be ready?
                    </button>
                  </h2>
                  <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                      Like us on Facebook or follow us on Twitter for exclusive information and offers. If you're only interested in the launch date, let us know by filling out the Contact section of this website.
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="section w-100" id="contact">
              <h3 class="text-bold" style="font-size: 30px; line-height: 35px;">Send us a message</h3>
               <!-- Second Form -->
                <form action="contactsubmit.php" method="post" class="mt-4" id="secondForm">
                    <div class="col-12 mt-3">
                        <input type="text" class="form-control" name="name" placeholder="Name" />
                    </div>
                    <div class="col-12 mt-3">
                        <input type="email" required class="form-control" name="email" placeholder="Email" />
                    </div>
                    <div class="col-12 mt-3">
                        <input type="tel" class="form-control" name="phone" placeholder="Phone" />
                    </div>
                    <div class="col-12 mt-3">
                        <textarea class="form-control" name="message" placeholder="Message"></textarea>
                    </div>
                    <!--<div class="col-12 mt-3">-->
                    <!--    <input type="text" class="form-control" name="word" placeholder="Type the word" />-->
                    <!--</div>-->
                    <div class="col-12 mt-3">
                        <!--<button type="submit" class="contact_submit">Send</button>-->
                        <input type="submit" id="contact_submit" class="w-100 w-sm-auto form-control contact_submit" value="Send" />
                    </div>
                </form>
                <div id="form-messages-second"></div> <!-- To display success or error messages -->
                <!-- Your Loading Spinner -->
                <div class="loadertwo catchakiwi-indicator-box">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="-200 -200 400 400"><defs><g id="p"><path fill="#5A9E16" d="M201.937,487.923c-11.376,10.978-22.025,21.262-32.684,31.537    c-16.313,15.73-32.348,31.766-49.032,47.092c-15.788,14.502-34.297,19.106-55.096,12.339c-7.403-2.409-13-7.348-17.926-13.108    c-12.81-14.984-21.973-43.985-6.071-67.953c5.099-7.684,12.125-14.123,18.493-20.923    c47.277-50.472,94.588-100.912,141.936-151.317c22.133-23.563,44.372-47.028,66.56-70.54c2.03-2.151,4.039-4.325,6.239-6.684    c-31.146-29.453-48.097-64.577-44.309-107.688c2.872-32.675,16.659-60.595,40.99-82.71c49.394-44.896,125.431-43.66,173.646,1.955    c47.171,44.627,57.522,129.345-3.045,186.439c5.735,6.17,11.458,12.375,17.231,18.531    c59.959,63.933,119.925,127.858,179.889,191.786c11.398,12.152,23.141,24.004,34.092,36.547    c10.376,11.884,13.214,26.399,10.936,41.688c-1.665,11.173-6.101,21.429-13.376,30.29c-14.19,17.285-38.378,22.285-59.234,10.803    c-8.873-4.886-16.726-12.015-24.155-19.061c-22.729-21.556-45.028-43.566-67.496-65.399c-0.597-0.58-1.182-1.176-1.811-1.721    c-4.393-3.81-7.46-2.812-8.577,2.836c-4.041,20.423-7.961,40.869-12.098,61.272c-13.832,68.226-27.8,136.425-41.598,204.657    c-13.657,67.54-27.145,135.113-40.771,202.659c-3.17,15.712-8.452,30.546-19.943,42.317    c-26.373,27.016-71.095,19.325-88.383-14.892c-7.115-14.082-9.551-29.319-12.582-44.485    c-11.973-59.914-24.045-119.809-36.052-179.716c-18.166-90.642-36.307-181.287-54.472-271.928    C202.985,491.287,202.545,490.064,201.937,487.923z" /></g></defs><g transform="rotate(0) translate(0,-112)" class="person" data-person="0"><g transform="scale(0.045) translate(-358,-520)"><use href="#p" xlink:href="#p" /></g></g><g transform="rotate(45) translate(0,-112)" class="person" data-person="1"><g transform="scale(0.045) translate(-358,-520)"><use href="#p" xlink:href="#p" /></g></g><g transform="rotate(90) translate(0,-112)" class="person" data-person="2"><g transform="scale(0.045) translate(-358,-520)"><use href="#p" xlink:href="#p" /></g></g><g transform="rotate(135) translate(0,-112)" class="person" data-person="3"><g transform="scale(0.045) translate(-358,-520)"><use href="#p" xlink:href="#p" /></g></g><g transform="rotate(180) translate(0,-112)" class="person" data-person="4"><g transform="scale(0.045) translate(-358,-520)"><use href="#p" xlink:href="#p" /></g></g><g transform="rotate(225) translate(0,-112)" class="person" data-person="5"><g transform="scale(0.045) translate(-358,-520)"><use href="#p" xlink:href="#p" /></g></g><g transform="rotate(270) translate(0,-112)" class="person" data-person="6"><g transform="scale(0.045) translate(-358,-520)"><use href="#p" xlink:href="#p" /></g></g><g transform="rotate(315) translate(0,-112)" class="person" data-person="7"><g transform="scale(0.045) translate(-358,-520)"><use href="#p" xlink:href="#p" /></g></g></svg>
                </div>
            </div>
            <div class="section w-100" id="sponsors">
              <h3 class="text-bold mb-3" style="font-size: 30px; line-height: 35px;">Our Sponsors</h3>
              <p>Please take time to visit our sponsors below. They're the reason we're making it free for you to use Catchakiwi. Thank you on behalf of the Catchakiwi team.</p>
              <div class="images d-flex flex-row flex-wrap" style="max-width: 530px;">
                <div class="col-12 col-sm-6 mt-2 px-1">
                  <img src="images/popup-image-1.png" style="max-width: 250px; width: 100%; margin: 0 auto;" alt="image-1" />
                </div>
                <div class="col-12 col-sm-6 mt-2 px-1">
                  <img src="images/popup-image-1.png" style="max-width: 250px; width: 100%; margin: 0 auto;" alt="image-1" />
                </div>
                <div class="col-12 col-sm-6 mt-2 px-1">
                  <img src="images/popup-image-1.png" style="max-width: 250px; width: 100%; margin: 0 auto;" alt="image-1" />
                </div>
                <div class="col-12 col-sm-6 mt-2 px-1">
                  <img src="images/popup-image-1.png" style="max-width: 250px; width: 100%; margin: 0 auto;" alt="image-1" />
                </div>
                <div class="col-12 col-sm-6 mt-2 px-1">
                  <img src="images/popup-image-1.png" style="max-width: 250px; width: 100%; margin: 0 auto;" alt="image-1" />
                </div>
                <div class="col-12 col-sm-6 mt-2 px-1">
                  <img src="images/popup-image-1.png" style="max-width: 250px; width: 100%; margin: 0 auto;" alt="image-1" />
                </div>
              </div>
            </div>
          </div>
        </div>
        </div>
      </div>
    </div>

   <div class="home_bg">
      <!-- Header start-->
      <div class="top_bar">
         <div class="container">
            <div class="row">
               <div class="col-lg-3 col-md-3 col-sm-3 col-3">
                    <p class="nz_region">
                        <select class="countryChange">
                            <option value="IN" {{ (session('CountryCode')=="IN")?"selected":"" }}>IN-India</option>
                            <option value="NZ" {{ (session('CountryCode')=="NZ")?"selected":"" }}>NZ-New Zealand</option>
                            <option value="AU" {{ (session('CountryCode')=="AU")?"selected":"" }}>AU-Australia</option>
                            <option value="CN" {{ (session('CountryCode')=="CN")?"selected":"" }}>CN-China</option>
                            <option value="ENG" {{ (session('CountryCode')=="ENG")?"selected":"" }}>ENG-United Kingdom</option>
                            <option value="US" {{ (session('CountryCode')=="US")?"selected":"" }}>US-United States</option>
                        </select>
                </p>
               </div>
               <div class="col-lg-9 col-md-9 col-sm-9 col-9 top_menu">
                  @include('includes/topmenu')
                  @include('includes/sidemenu')
               
            
         </div>
        </div>
      <div class="container">
         <div class="logo">
            <h1><a href="{{ URL::to('/') }}"><img src="{{ asset('assets/images/logo.png') }}" alt="" /></a></h1>
         </div>
      </div>
      <!-- Header start end-->
      <!-- body start-->
      <div class="container">
         <div class="home_midbody">
            <h2>Search Your Kiwi Business Community</h2>
            <p>So often, two people who need to connect walk straight past each other in the street. Don't let Catchakiwi
               become just an online community, let it become the hub of our community.
            </p>
            <!--<button class="p-3 d-flex align-items-center justify-content-center newcacpop" id="newcacpop">-->
            <!--    <span class="me-sm-3">The new catchakiwi is coming</span>-->
            <!--    <div class="bg">-->
            <!--      <div class="loader"></div>-->
            <!--    </div>-->
            <!--  </button>-->
            <div class="home_searchsec">
               <form action="" method="post">
                  <input name="" type="text" placeholder="Services I’m looking for" />
                  <input name="" type="text" placeholder="Enter your location" class="location" />
                  <input name="" type="submit" value="Search" />
               </form>
            </div>
            @if(Auth::user())
                <div class="add_getqutebutton"><a href="{{ URL::to('/add-your-board') }}">Add Your Business</a> <a href="{{ URL::to('/get-a-quote') }}">Get a Quote</a></div>
            @else
                <div class="add_getqutebutton"><a href="{{ URL::to('/login') }}">Add Your Business</a> <a href="{{ URL::to('/get-a-quote') }}">Get a  Quote</a></div>
            @endif
         </div>
      </div>
      <div class="for_cellphonepara">
         <p>So often, two people who need to connect walk straight past each other in the street. Don't let Catchakiwi
            become just an online community, let it become the hub of our community.
         </p>
      </div>
      </div>
      <!-- body start end-->
@include('includes/footer')
<script>
      $(document).ready(function () {
        $(".popup_close").click(function () {
          $(".popup_outer").hide();
        });
        $("#newcacpop").click(function () {
          $(".popup_outer").show();
        });
      });
    </script>

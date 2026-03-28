<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catchakiwi</title>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        
        /* Logo */
        .logo {
            text-align: center;
            margin-bottom: 20px;
        }
        
        .logo img {
            width: 225px; /* Adjust size of the logo */
        }
        
        /* Company Info */
        .company-info {
            text-align: center;
            margin-bottom: 20px;
        }
        
        .company-info h1 {
            font-size: 28px;
            font-weight: bold;
            margin: 0;
        }
        
        .company-info p {
            font-size: 16px;
            color: #666;
        }
        
        .ratings {
            font-size: 18px;
            color: #ffd700;
        }
        
        /* Company Image */
        .company-image {
            text-align: center;
            margin: 20px 0;
        }
        
        .company-image img {
            max-width: 70%;
            height: auto;
        }
        
        /* Contact Details */
        .contact-details {
            text-align: center;
            font-size: 14px;
            margin-bottom: 20px;
        }
        
        .contact-details a {
            color: #0073e6;
            text-decoration: none;
        }
        
        .contact-details a:hover {
            text-decoration: underline;
        }
        
        /* Description */
        .description {
            font-size: 14px;
            margin-bottom: 40px;
        }
        
        /* Footer */
        footer {
            text-align: center;
            font-size: 12px;
            color: #666;
            margin-top: 40px;
            border-top: 1px solid #ccc;
            padding-top: 10px;
        }
        
        footer p {
            margin: 5px 0;
        }

    </style>
</head>
<body>

    <!-- Container for the content -->
    <div class="container">

        <!-- Logo -->
        <!--<div class="logo">
            <a href="{{ URL::to('/') }}"><img src="{{ asset('assets/images/logo-print.png') }}" alt="" /></a>
        </div>-->

        <!-- Company Info -->
        <div class="company-info">
            <h1>{{$business->display_name}}</h1>
            <?php
               if($business->homebased_business == "yes"){
               ?>
                    <p >This is a Home-Based Business</p>
               <?php
               }
             ?>
            <div class="ratings">
                <span>★</span><span>★</span><span>★</span><span>★</span><span>★</span> (0/No ratings yet)
            </div>
        </div>

        <!-- Company image -->
        <div class="company-image">
            @if($business->select_image) 
                <img src="<?= asset($business->select_image) ?>" alt="">
             @else 
                <img src="{{ asset('assets/images/cam_img.png') }}" alt="">
             @endif
        </div>

        <!-- Contact details -->
        <div class="contact-details">
            <p>P <?= $business->main_phone ?> | <?= $business->email_address ?> | <?php if ($business->website_url != ""): ?>Website: <a href="{{$business->website_url}}">{{$business->website_url}}</a> <?php endif; ?></p>
            <!--<p>47 Hookway Grove Paraparaumu</p>-->
                <p><?= (($business->display_address == "yes")?$business->address.", ":"") . $business->region ?></p>
        </div>

        <!-- Description -->
        <div class="description">
            <h2>Description</h2>
            <p><?= $business->business_description ?></p>
        </div>

        <!-- Footer -->
        <footer>
            <p><?= $currentUrl ?></p>
            <p>Proudly Kiwi Owned & Operated</p>
        </footer>

    </div>
<script>
    function printAndClose() {
            window.print(); // Open the print dialog

            // Close the window after the print dialog has been closed (either printed or canceled)
            window.onafterprint = function() {
                window.location.href = "<?= $currentUrl ?>"; // Close the window
            };
        }

        // Run the print and close function when the page loads
        window.onload = printAndClose;
</script>
</body>
</html>

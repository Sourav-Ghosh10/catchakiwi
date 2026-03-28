<?php
request()->path()
?>
<!-- footer start-->
<div class="full_footer home">
<div class="container">
<div class="footer_logo"><a href="#"><img src="../images/footer_logo.png" alt="" /></a></div>
<div class="footer_links">
<ul>
 <li style="font-weight:{{ (request()->path()=='terms-and-condition')?600:'' }}"><a href="{{ URL::to('/terms-and-condition') }}">Terms & Conditions</a></li>
          <li style="font-weight:{{ (request()->path()=='privercy-policy')?600:'' }}"><a href="{{ URL::to('/privercy-policy') }}">Privacy Policy</a></li>
          <li><a href="https://catchakiwi.com/advertising-agreement.pdf" target="_blank">Advertise</a></li>
          <li style="font-weight:{{ (request()->path()=='contact-us')?600:'' }}"><a href="{{ URL::to('contact-us') }}">Contact Us</a></li>
</ul>
</div>
<div>
<div class="fot_copyr">
<p class="powerdby">Proudly Kiwi Owned & Operated</p>
<p class="copy">© 2024 All Rights Reserved, Catchakiwi Limited</p>
<p class="social">
<a href="#"><img src="../images/footer_fb.png" alt="" /></a>
<!--<a href="#"><img src="../images/footer_instagram.png" alt="" /></a>-->
<a href="#"><img src="../images/footer_twitter.png" alt="" /></a>
<a href="#"><img src="../images/footer_linkdin.png" alt="" /></a>
</p>
</div>
</div>
</div>
</div>
<!-- footer start end-->
</div>
<!--<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>-->

<!-- jQuery UI FIRST -->
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

<!-- Bootstrap AFTER -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
  $( function() {
    $( "#accordion" ).accordion({
		collapsible: true,
      heightStyle: "content"
    });
  } );
  </script>
    <script>
  $( function() {
    $( "#proaccordion" ).accordion({
	  collapsible: true,
      heightStyle: "content"
	  
    });
  } );
  </script>
  <script defer>
jQuery(function(){

	jQuery('.pass_resetbutt').on('click',function(){
		jQuery('.overlaybg, .changepasspopup').show(800);//800
	});

	jQuery('.closepop').click( function(){
		$('.overlaybg, .changepasspopup').hide(800);
	});
});
</script>
<!--<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>-->
<!--<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">-->
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>-->
 <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js"></script>

<script>
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
    $(document).ready(function () {
        $('#country').change(function () {
            var selectizeInstance = $('#towns_id')[0].selectize;
            var countryId = $(this).val();
            //alert(countryId);
            $.ajax({
                url: 'getCityState', // Replace with your backend route to fetch cities
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
                },
                error: function (xhr, status, error) {
                    console.error(error);
                }
            });
        });
        $('#country').trigger('change');
    });
    
    
    $(document).ready(function() {
        
        
        // Show/Hide selectize control based on word count
        $('#towns_id-selectized').on('keyup click', function() {
            var selectizeInstance = $('#towns_id')[0].selectize;
            const inputValue = $(this).val().trim();
            const wordCount = inputValue.length;
            
            if (wordCount > 1) {
                
                selectizeInstance.$dropdown.css('display', 'block');
            } else {
                selectizeInstance.$dropdown.css('display', 'none');
            }
        });
        
        // Initial check in case input box already has value
        $('#towns_id-selectized').trigger('keyup');
    });

</script>
<script>
$(document).ready(function () {
  // Toggle for message notification
  $(".msg_notift").click(function (e) {
    e.stopPropagation();
    $(".notifidrop").toggle();
    $(".msgdrop").hide(); // close other dropdown
  });

  // Toggle for email notification
  $(".email_notift").click(function (e) {
    e.stopPropagation();
    $(".msgdrop").toggle();
    $(".notifidrop").hide(); // close other dropdown
  });

  // Close both when clicking outside
  $(document).click(function (e) {
    if (!$(e.target).closest(".notifidrop, .msgdrop, .msg_notift, .email_notift").length) {
      $(".notifidrop, .msgdrop").hide();
    }
  });

  // Optional: close both on ESC
  $(document).keyup(function (e) {
    if (e.key === "Escape") {
      $(".notifidrop, .msgdrop").hide();
    }
  });
});
</script>

<!--<script>
$(document).ready(function(){
  $(".msg_notift").click(function(){
    $(".notifidrop").toggle();
  });
});
</script> -->
<!--<script>
$(document).ready(function(){
  $(".email_notift").click(function(){
    $(".msgdrop").toggle();
  });
});
</script>-->
<script src="{{ asset('assets/js/custom.js') }}"></script>
<script src="{{ asset('assets/js/home_popup.js') }}"></script>
<style>
    .selectize-dropdown{
        /*display:none;*/
    }
</style>

<script>
/* =============================================================
   HEADER: Real-time Messages Dropdown (email_notift)
   ============================================================= */

function updateHeaderMessages() {
    // 1. Get unread counts
    fetch('/chat/unread', {
        headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(r => r.json())
    .then(unreadCounts => {
        const total = Object.values(unreadCounts).reduce((a, b) => a + b, 0);
        const badge = document.getElementById('headerMsgCount');
        if (badge) {
            badge.textContent = total;
            badge.style.display = total > 0 ? 'inline-block' : 'none';
        }

        if (total === 0) {
            const list = document.getElementById('headerMsgList');
            if (list) list.innerHTML = '<li style="text-align:center; color:#999; padding:15px;">No new messages</li>';
            return;
        }

        // 2. Get recent conversations
        fetch('/chat/list', {
            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(r => r.json())
        .then(users => {
            const list = document.getElementById('headerMsgList');
            if (!list) return;

            // FILTER: Only users with unread_count > 0
            const unreadUsers = users
                .filter(u => (unreadCounts[u.id] || 0) > 0)
                .sort((a, b) => {
                    // Sort by last message time (newest first)
                    return (b.last_message_time || '').localeCompare(a.last_message_time || '');
                });

            if (unreadUsers.length === 0) {
                list.innerHTML = '<li style="text-align:center; color:#999; padding:15px;">No new messages</li>';
                return;
            }

            list.innerHTML = unreadUsers.map(u => `
                <li class="active" style="cursor:pointer;" onclick="openChatInProfile(${u.id})">
                    <img src="${u.image || '{{ asset('assets/images/profile_pic.png') }}'}" 
                         alt="${u.name}" style="width:40px;height:40px;border-radius:50%;object-fit:cover;">
                    <div class="nitif_right">
                        <h3 style="margin:0;font-size:14px;font-weight:600;">
                            ${u.name}
                            <span style="font-weight:normal;font-size:11px;color:#666;">
                                ${formatTime(u.last_message_time)}
                            </span>
                        </h3>
                        <p style="margin:3px 0 0;font-size:13px;color:#333;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:180px;">
                            ${u.last_message ? truncate(u.last_message, 35) : 'Sent a message'}
                        </p>
                    </div>
                </li>
            `).join('');
        });
    })
    .catch(err => {
        console.error('Header messages error:', err);
        const list = document.getElementById('headerMsgList');
        if (list) list.innerHTML = '<li style="color:red;padding:10px;">Error loading</li>';
    });
}

function formatTime(apiTimeStr) {
    if (!apiTimeStr) return 'Just now';
    const [timePart, datePart] = apiTimeStr.split(', ');
    if (!timePart || !datePart) return apiTimeStr;

    const [time, period] = timePart.split(' ');
    let [hours, minutes] = time.split(':').map(Number);
    if (period === 'PM' && hours !== 12) hours += 12;
    if (period === 'AM' && hours === 12) hours = 0;

    const months = { Jan:0, Feb:1, Mar:2, Apr:3, May:4, Jun:5, Jul:6, Aug:7, Sep:8, Oct:9, Nov:10, Dec:11 };
    const [monthStr, dayStr] = datePart.split(' ');
    const month = months[monthStr];
    const day = parseInt(dayStr);
    const year = new Date().getFullYear();

    const date = new Date(year, month, day, hours, minutes);

    const weekdays = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
    const monthsLong = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

    const weekday = weekdays[date.getDay()];
    const monthName = monthsLong[date.getMonth()];
    const dayNum = date.getDate();
    const hour12 = date.getHours() % 12 || 12;
    const minute = date.getMinutes().toString().padStart(2, '0');
    const ampm = date.getHours() >= 12 ? 'PM' : 'AM';

    return `${weekday}, ${monthName} ${dayNum}, ${hour12}:${minute} ${ampm}`;
}

function truncate(str, n) {
    return str.length > n ? str.substr(0, n - 1) + '...' : str;
}

function openChatInProfile(userId) {
    window.open('https://catchakiwi.com/profile#parentHorizontalTab3', '_self');
}

// Run every 12 seconds
setInterval(updateHeaderMessages, 12000);

// Run on page load
document.addEventListener('DOMContentLoaded', updateHeaderMessages);

// Also run when refreshBadges() is called (from chat)
if (typeof refreshBadges === 'function') {
    const oldRefresh = refreshBadges;
    window.refreshBadges = function() {
        oldRefresh();
        updateHeaderMessages();
    };
}
</script>

<script>
$(document).ready(function() {
    // Toggle dropdown
    let isOpen = false; // Track state manually

    // Toggle dropdown on bell click
    $('#notificationBell').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation(); // Prevent bubbling

        if (isOpen) {
            $('#notificationDropdown').slideUp(200);
            isOpen = false;
        } else {
            $('#notificationDropdown').slideDown(200);
            isOpen = true;
        }
    });

    // Close dropdown when clicking outside
    $(document).on('click', function(e) {
        if (!$(e.target).closest('#notificationBell, #notificationDropdown').length) {
            $('#notificationDropdown').hide();
        }
    });

    // Click on notification item → open modal + mark as read
    $(document).on('click', '.notification-item', function() {
        const notifId = $(this).data('id');
        const title = $(this).find('strong').text();
        const message = $(this).find('p').data('full-message') || $(this).find('p').text(); // we'll set full later
        const time = $(this).find('small').text();

        $('#modalTitle').text(title);
        $('#modalMessage').html($(this).find('p').data('full-message') || $(this).find('p').text().replace(/\n/g, '<br>'));
        $('#modalTime').text(time);
        $('#notificationModal').modal('show');

        // Mark as read if not already
        if ($(this).hasClass('unread')) {
            $.post('{{ route("notification.read") }}', {
                _token: '{{ csrf_token() }}',
                notification_id: notifId
            }).done(function() {
                $(`[data-id="${notifId}"]`).removeClass('unread');
                updateUnreadCount();
            });
        }
    });

    function updateUnreadCount() {
        const count = $('.notification-item.unread').length;
        $('#unreadCount').text(count);
        if (count === 0) $('#unreadCount').hide();
    }
});
</script>
</body>
</html>
(function ($, window) {
	/** Settings **/

	// List of background images to use, the default image will be the first one in the list
	var backgrounds = [
		'images/backgrounds/placeholder.jpg'
	],

		// Background options - see documentation
		backgroundOptions = {

		},

		// Twitter username
		twitterUsername = 'catchakiwi',

		// Number tweets to show, set to 0 to disable
		tweetCount = 2,

		// The final percentage the bar should animate to
		progressPercentage = 70,

		// The time to complete the bar animation in milliseconds, 1000 = 1 second
		progressAnimationSpeed = 2000,

		// Enter your launch date
		launchDate = {
			day: 01,
			month: 06,
			year: 2013,
			hour: 12,
			min: 0,
			sec: 0
		},

		// Months
		months = {
			1: 'Jan',
			2: 'Feb',
			3: 'Mar',
			4: 'Apr',
			5: 'May',
			6: 'Jun',
			7: 'Jul',
			8: 'Aug',
			9: 'Sep',
			10: 'Oct',
			11: 'Nov',
			12: 'Dec'
		};

	/** End settings **/

	$('html').addClass('js-enabled');

	$(document).ready(function () {
		// $.fullscreen(
		// 	$.extend(backgroundOptions, {
		// 		backgrounds: window.backgrounds || backgrounds,
		// 		backgroundIndex: window.backgroundIndex
		// 	})
		// );

		$('#countdown_dashboard').countDown({
			targetDate: launchDate,
			omitWeeks: true
		});

		$('.launch-date-wrap .day').html(launchDate.day);
		$('.launch-date-wrap .month').html(months[launchDate.month]);
		$('.launch-date-wrap .year').html(launchDate.year);

		$('.fancybox-portfolio a.portfolio-thumb-link').fancybox({
			'transitionIn': 'elastic',
			'transitionOut': 'elastic',
			'speedIn': 600,
			'speedOut': 200,
			'overlayColor': '#111',
			onStart: $.fullscreen.unbindKeyboard,
			onClosed: $.fullscreen.bindKeyboard
		});

		// Footer pop out boxes
		$('.footer-pop-out-trigger', '#footer').click(function () {
			var $trigger = $(this);
			var $allBoxes = $('.footer-pop-out-box', '#footer');
			if ($allBoxes.is(':animated')) {
				return false;
			}

			var thisId = $trigger.attr('id').substring(16);
			var $thisBox = $('#' + thisId + '-pop-out');
			if ($thisBox.is(':visible')) {
				$('.footer-pop-out-trigger').removeClass('footer-pop-active');
				$thisBox.slideUp();
			} else {
				if ($allBoxes.is(':visible')) {
					$('.footer-pop-out-trigger').removeClass('footer-pop-active');
					$allBoxes.filter(':visible').slideUp(function () {
						$trigger.addClass('footer-pop-active');
						$thisBox.slideDown();
					});
				} else {
					$trigger.addClass('footer-pop-active');
					$thisBox.slideDown();
				}
			}

			return false;
		});

		// Make the form inputs clear value when focused
		$('.toggle-val').toggleVal({ populateFrom: 'label', removeLabels: true });

		// Create the gallery rollover effect
		$('li.one-portfolio-item a').append(
			$('<div class="portfolio-hover"></div>').css({ opacity: 0, display: 'block' })
		).live('mouseenter', function () {
			$(this).find('.portfolio-hover').stop().fadeTo(400, .5);
		}).live('mouseleave', function () {
			$(this).find('.portfolio-hover').stop().fadeTo(400, 0.0);
		});

		$('.social-list-small a').css({ opacity: 0.3 }).live('mouseenter', function () {
			$(this).stop().fadeTo(400, 0.8);
		}).live('mouseleave', function () {
			$(this).stop().fadeTo(400, 0.3);
		});

		$('#tabs').tabs({ fx: { opacity: 'toggle', duration: 'slow' } });
	}); // End (document).ready

	$(window).load(function () {
		// Animate progress bar
		if (progressPercentage < 1) {
			progressPercentage = 1;
		} else if (progressPercentage > 100) {
			progressPercentage = 100;
		}
		var progressBarWrap = $('#progress-bar-wrap');
		var progressAmount = $('#progress-amount');
		var targetWidth = $('#progress-wrap').width() * (progressPercentage / 100);
		progressBarWrap.animate({
			width: targetWidth
		}, progressAnimationSpeed, function () {
			$('#moving-arrow').fadeIn('slow');
			progressAmount.text(progressPercentage + '%').fadeIn('slow')
		}).css('overflow', 'visible');
		$('#progress-indicator').fadeIn('slow');

		$('.homepage-slider-loading').remove();
		$('ul#homepage-slider').show().anythingSlider({
			width: 540,
			height: 52,
			resizeContents: false,
			delay: 6000,
			animationTime: 1200,
			buildNavigation: false,
			buildStartStop: false
		});

		// Load the Twitter feed
		if (twitterUsername && tweetCount > 0) {
			(function () {
				var t = document.createElement('script'); t.type = 'text/javascript'; t.src = 'http://twitter.com/statuses/user_timeline/' + twitterUsername + '.json?callback=twitterCallback2&count=' + tweetCount;
				var h = document.getElementsByTagName('head')[0]; h.appendChild(t);
			})();
		}
	}); // End (window).load	

	// Any images to preload
	window.preload([
		'images/close1.png',
		'images/close.png',
		'images/minimise1.png',
		'images/minimise.png',
		'images/3-col-hover.png',
		'images/light-bg-rep.png',
		'images/dark-bg-rep.png',
		'images/dark-play.png',
		'images/dark-pause.png',
		'images/light-play.png',
		'images/light-pause.png'
	]);
})(jQuery, window);

(function($){
	var firstAnim = true;



	$(window).on('contentReady', function(){
		firstAnim = true;

		if($('.about').length === 0) {
			return;
		}
		if($('.about-styles').length > 0) {
			$('.about-styles').remove();
		}
		$('head style').first().append('<style id="about-styles"></style>').append($('.custom-styles').text());

		$( '.swipebox-video' ).swipebox();
		// if(!window.mobile && !window.ipad) {
		// 	$(".player").each(function(i, el) {
		// 		$(el).mb_YTPlayer();
		// 	});
		// 	$('.mobile-video-controls').addClass('hide-for-large');
		// 	$('.player').parent().addClass('show-for-large');

		// } else {
		// 	$('.mobile-video-controls').removeClass('hide-for-large');
		// 	$('.player').parent().hide();
		// }

		var slugs = [];
		$('.about-sections .about-section').each(function(){
			slugs.push($(this).data('slug'));
		});

		var pagination = $('.about-sections').data('pagination');
		var slidesCount = $('.about-section').length;
		$('.about-sections').fullpage({
			navigation: pagination,
			scrollingSpeed: 1000,
			easingcss3: 'cubic-bezier(0.6, 0, 0.3, 1)',
			loopBottom: true,
			animateAnchor: false,

			afterRender: function() {
				firstAnim = true;
				$('.nav-'+$('.fp-section.active').data('navigation')).velocity({opacity: 1}, 0);

				$('.fp-section.active .player').on("YTPReady", function(){
					setTimeout(function(){
						$('.fp-section.active .player').playYTP();
					}, 0);
				});
				$('#fp-nav a').data('djaxExclude', true);
			},
			afterLoad: function(anchorLink, index){
				var current = index-1;
				if(firstAnim === false) {
					$(window).trigger('aboutSlideChange');
					$(this).find('.about-content-wrapper').velocity('transition.slideDownIn');
					$(this).find('.close-content-section').velocity({ opacity: 1 });
				}
				var arrowColor = $(this).data('arrow-color');
				var arrowBg = $(this).data('arrow-bg');

				var paginationColor = $(this).data('pagination');
				var paginationHover = $(this).data('pagination-hover');
				$('.nav-slider-arrows .arrow-slide svg').css('stroke', arrowColor);
				$('.nav-slider-arrows').css('background-color', arrowBg);

				$('#fp-nav li').css('color', paginationColor);
				var css = '<style>#fp-nav li a.active::after{background-color: '+paginationColor+';} #fp-nav li::after{background-color: '+paginationHover+';}</style>';
				document.head.insertAdjacentHTML( 'beforeEnd', css );
				
				
				if(window.mobile || window.ipad)
					return;
				if($('.about-section:eq('+current+') .player').length > 0) {
					$('.fp-section.active .player').on("YTPReady", function(){
						setTimeout(function(){
							$('.about-section:eq('+current+') .player').playYTP();
						},0);
					});
					$('.about-section:eq('+current+') .player').playYTP();
				}
			},
			onLeave: function(index, nextIndex, direction) {
				nextIndex--;
				var navigation = $(this).data('navigation'),
					nextNavigation = $('.about-section:eq('+nextIndex+')').data('navigation');
				$(this).find('.about-content-wrapper').velocity('stop').velocity({ opacity: 0 });
				$(this).find('.close-content-section').velocity('stop').velocity({ opacity: 0 });
				$('.nav-'+navigation).velocity({opacity: 0}, 0);
				$('.nav-'+nextNavigation).velocity({opacity: 1}, 0);
				var current = index-1;
				if(window.mobile || window.ipad)
					return;
				if($('.about-section:eq('+current+') .player').length > 0 ) {
					if(typeof $('.about-section:eq('+current+') .player').YTPlayer() === 'function') {
						$('.about-section:eq('+current+') .player').pauseYTP();
					}
				}
			},
		});


		$('.nav-slider-arrows').on('click', function(){
			$.fn.fullpage.moveSectionDown();
		});
		$('.about').each(function(){
			var that = $(this);
			if(that.find('.about-section').length === 1) {
				that.find('.nav-slider-arrows').hide();
				$('#fp-nav').hide();
			} else {
				that.find('.nav-slider-arrows').show();
				$('#fp-nav').show();
			}
		});
		$('.about-section').each(function(){
			var that = $(this);
			var closeSection = that.find('.close-content-section');
			var openSection = that.find('.open-content-section');

			closeSection.on('click', 'a', function(e){
				e.preventDefault();

				closeSection.parents('.about-section').removeClass('open-content');
				closeSection.velocity('fadeOut');
				that.find('.section-overlay').velocity('fadeOut');
				if(closeSection.parents('.about-section').hasClass('pos_right')) {
					closeSection.parents('.about-section').find('.row').velocity('fadeOut', {complete: function(){
						closeSection.parents('.about-section').find('.half-overlay').velocity({translateX: ['100%', '0']}, { duration: 800, easing: [0.6, 0, 0.3, 1], complete: function(){
							openSection.velocity('fadeIn', {complete: function(){
								that.addClass('close-content');
							}});
						}});
					}});
				} else {
					closeSection.parents('.about-section').find('.row').velocity('fadeOut', {complete: function(){
						closeSection.parents('.about-section').find('.half-overlay').velocity({translateX: ['-100%', '0']}, { duration: 800, easing: [0.6, 0, 0.3, 1], complete: function(){
							openSection.velocity('fadeIn', {complete: function(){
								that.addClass('close-content');
							}});
						}});
					}});
				}

			});
			openSection.on('click', 'a', function(e){
				e.preventDefault();

				openSection.velocity('fadeOut');
				that.find('.section-overlay').velocity('fadeIn');
				if(closeSection.parents('.about-section').hasClass('pos_right')) {
					openSection.parents('.about-section').find('.half-overlay').velocity({translateX: ['0', '100%']}, { duration: 800, easing: [0.6, 0, 0.3, 1], complete: function(){
						openSection.parents('.about-section').find('.row').velocity('fadeIn', {complete: function(){
						}});
							closeSection.velocity('fadeIn', {delay: 0, complete: function(){
								that.addClass('open-content');
								openSection.parents('.about-section').removeClass('close-content');
							}});
					}});
				} else {
					openSection.parents('.about-section').find('.half-overlay').velocity({translateX: ['0', '-100%']}, { duration: 800, easing: [0.6, 0, 0.3, 1], complete: function(){
						openSection.parents('.about-section').find('.row').velocity('fadeIn', {complete: function(){
						}});
							closeSection.velocity('fadeIn', {delay: 0, complete: function(){
								that.addClass('open-content');
								openSection.parents('.about-section').removeClass('close-content');
							}});
					}});
				}
			});
		});
	});

	$(window).on('contentLoaded', function(){
		$(window).trigger('aboutSlideChange');
		firstAnim = false;
		$('.fp-section.active').find('.about-content-wrapper').velocity('transition.slideDownIn');
		$('.fp-section.active').find('.close-content-section').velocity({ opacity: 1 });
		$('.page-wrapper').addClass('show-additional');

		if(!window.mobile && !window.ipad) {
			$(".player").each(function(i, el) {
				$(el).mb_YTPlayer();
			});
			$('.mobile-video-controls').addClass('hide-for-large');
			$('.player').parent().addClass('show-for-large');

		} else {
			$('.mobile-video-controls').removeClass('hide-for-large');
			$('.player').parent().hide();
		}
	});

})(jQuery);
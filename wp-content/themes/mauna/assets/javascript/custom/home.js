(function($){
	'use strict';

	var autopager;
	var mobile = false;
	var ipad = false;
	$(window).on('contentReady', function(){
		if($('.page-wrapper > .homepage').length === 0) {
			return;
		}

		$('.scene').parallax();
		var animation = $('.parallax-slides').data('animation');
		var transition = $('.parallax-slides').data('transition');
		var delay = $('.parallax-slides').data('delay');
		var transitionDuration = $('.parallax-slides').data('transitionDuration');

		var slides = [];
		$('.single-slide').each(function(){
			var slide = $(this).data('slide');
			slides.push({'src' : slide});
		});

		$('.parallax-slides.slides-multiple' ).vegas({
			delay: delay,
			animation: animation,
			transition: transition,
			transitionDuration: transitionDuration,
			slides: slides
		});
		$('.vegas-timer').appendTo('.page-wrapper');
	});
	

	$(window).on('contentLoaded', function(){
		if($('.page-wrapper > .homepage').length === 0) {
			return;
		}
		var players = [];
		$( '.swipebox-video' ).swipebox();

		$(".player").each(function(i, el) {
			var player = {};
			$(el).mb_YTPlayer();
			player.el = $(el);
			player.container = $(el).parents('.homepage');

			$(el).on('YTPReady', function(){
				player.container.find(".home-video-controls").not('.home-video-control-down').find(".play").velocity('fadeIn');
				player.container.find(".home-video-control-down .pause").velocity('fadeIn');
			});
			if (!window.mobile && !window.ipad) {
				player.container.find(".home-video-controls .pause").click(function() {
					player.el.pauseYTP();
					player.container.find(".home-video-controls .pause").velocity('fadeOut');
					player.container.find(".home-video-controls .play").velocity('fadeIn');
				});

				player.container.find(".home-video-controls .play").click(function() {
					player.el.playYTP();
					player.container.find(".home-video-controls .play").velocity('fadeOut');
					player.container.find(".home-video-controls .pause").velocity('fadeIn');
				});
				$('.home-mobile-video-control').addClass('hide-for-large');
				$('.player').parent().addClass('show-for-large');
			} else {
				player.container.find('.home-mobile-video-control').removeClass('hide-for-large');
				$('.player').parent().hide();

			}
		});
		$('.homepage').each(function(){
			var $that = $(this),
				canClick = true;

			$that.find('.navbar-top .burger-nav').on('click', function(){
				if(canClick === true) {
					$that.find('> .navbar-top .logo-sm').velocity('fadeOut');
					canClick = false; 
				} else {
					$that.find('> .navbar-top .logo-sm').velocity('fadeIn', {display: 'inline-block'});
					canClick = true; 
				}
				
			});
		});
	});
})(jQuery);
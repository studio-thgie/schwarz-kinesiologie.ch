(function($){
	"use strict";


	$(document).ready(function(){
		$(window).trigger('contentReady');
		jQuery('.end-row').after('<div class="row-helper">');
		$('.start-row').each(function(){
			$(this).nextUntil('.row-helper').addBack().wrapAll('<div class="row">');
		});

	});

	$(window).on('load', function(){
		$('.body-wrapper').velocity({opacity: 1}, 400);
		$('.page-mask').velocity({ translateX: ['-100vw', '0'], translateZ: 0 }, { queue: false, delay: 200, duration: 800, easing: [0.6, 0, 0.3, 1], complete: function(){
			$(window).trigger('contentLoaded');
		}});
	});

	$(window).on('contentLoaded', function(){
		homeMenu();
		$(".portfolio-sidebar").stick_in_parent({
			offset_top: 60
		});
		$('.portfolio-single-post .margin-top-intro, .default-page-template .margin-top-intro').each(function(){
			var $that = $(this);
			var navbarHeight = $('.navbar-top').height();
			$that.css('margin-top', -navbarHeight + 60);
		});
		$('.portfolio-single-post .portfolio-arrow-intro').on('click', function(){
			$('.portfolio-sidebar').velocity('scroll', { duration: 1000 });
		});
		$('.default-page-template .default-arrow-intro').on('click', function(){
			$('.margin-top-intro > div').velocity('scroll', { duration: 1000 });
		});
		$( 'iframe[src*="youtube.com"]').wrap("<div class='flex-video widescreen'/>");
		$( 'iframe[src*="vimeo.com"]').wrap("<div class='flex-video widescreen vimeo'/>");
		showScrollToTop();

	});

	$(window).resize(function(){
		homeMenu();
		$('.portfolio-single-post .margin-top-intro, .default-page-template .margin-top-intro').each(function(){
			var $that = $(this);
			var navbarHeight = $('.navbar-top').height();
			$that.css('margin-top', -navbarHeight + 60);
		});
	});

	function showScrollToTop() {
		$('#scroll-up').off('click.scrollTop');
		$('#scroll-up').on('click.scrollTop', function(e){
			e.preventDefault();
			$('body').velocity('scroll', {'offset': 0});
		});
		var windowHeight = $(window).height();
		$(window).off('scroll.toTop');
		$(window).on('scroll.toTop', function(){
			var top = window.pageYOffset || document.documentElement.scrollTop;
			if(top > ((windowHeight / 3) * 2)) {
				$('#scroll-up').addClass('show-scroll-up');
			} else {
				$('#scroll-up').removeClass('show-scroll-up');
			}
		});
	}

	// H O M E

	function homeMenu() {
		var position = $('.homepage .home-nav li');
		if(position.length === 0) {
			return;
		}
		position = position.first().position().top;
		var counter = 0;
		$('.homepage .home-nav .first-el').removeClass('first-el');
		$('.homepage .home-nav .prev-el').removeClass('prev-el').remove();
		$('.homepage .home-nav li').each(function(i, el){
			var element = $(this);
			if(element.position().top > position) {
				counter++;
				if(counter % 2 === 0) {
					element.addClass('first-el');
				}
				position = element.position().top;
			}
		});
	}

	$(window).on('contentReady', function(){

		$('.mauna-gallery').each(function(){
			var rel = 'post-gallery-'+$(this).data('id');
			$('.gallery-lightbox-wrapper a').attr('rel', rel).addClass('no-rd gallery-lightbox').swipebox();
		});
		$('.gallery-lightbox').swipebox({

		});

		$('.mauna-woocommerce .zoom').swipebox();
	});

	$(window).on('contentLoaded', function(){

		$('.open-off-canvas').on('click', 'a', function(e){
			e.preventDefault();
			$('.open-off-canvas').velocity('fadeOut');
			var offCanvasTrans = '';
			if ($(window).width() >= 1024) {
				offCanvasTrans = '-50%';
			} else {
				offCanvasTrans = '-100%';
			}
			$('.off-canvas-wrapper').velocity({translateX: [0,offCanvasTrans]}, { display: 'block', duration: 800, easing: [0.6, 0, 0.3, 1], complete: function(){
				$('.off-canvas-wrapper .off-canvas-content').velocity('fadeIn');
				$('.close-off-canvas').velocity('fadeIn');
			}});
		});
		$('.close-off-canvas').on('click', 'a', function(e){
			e.preventDefault();
			var that = $(this);
			var offCanvasTrans = '';
			if ($(window).width() >= 1024) {
				offCanvasTrans = '-50%';
			} else {
				offCanvasTrans = '-100%';
			}
			$('.close-off-canvas').velocity('fadeOut');
			$('.off-canvas-wrapper .off-canvas-content').velocity('fadeOut', {complete: function(){
				$('.off-canvas-wrapper').velocity({translateX: [offCanvasTrans, 0]}, { duration: 800, easing: [0.6, 0, 0.3, 1], display: 'none' });
					$('.open-off-canvas').velocity('fadeIn');
			}});
		});

		var windowWidth = $(window).width();
		$('.portfolio-carousel, .promotion-news-carousel, .portfolio-carousel2').mousemove(function(e){
			var xPrev = 0;
			xPrev=e.pageX;

			if(xPrev < windowWidth/2) {
				$('.portfolio-slide-prev').addClass('show-arrow');
				$('.portfolio-slide-next').removeClass('show-arrow');
			} else {
				$('.portfolio-slide-next').addClass('show-arrow');
				$('.portfolio-slide-prev').removeClass('show-arrow');
			}
		});
		$( '.swipebox:not([href=\\#])' ).swipebox();
	});
})(jQuery);

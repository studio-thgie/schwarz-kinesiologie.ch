(function($){
	'use strict';

	var autopager;
	var mobile = false;
	var ipad = false;


	$(window).on('resize', $.debounce( 250, function() {
		setWidth();
		setBgImages();
	}));

	$(window).on('contentReady', function(){
		if($('.page-wrapper > .homepage2').length === 0) {
			return;
		}
		setWidth();
		setBgImages();
	});
	function setBgImages() {
		if(!window.mobile && !window.ipad && $(window).outerWidth() >= 1024) {
			$('.homepage2 .home-nav-item').each(function(){
				var $that = $(this);

				if($('.homepage2 .home-nav-items').hasClass('bg-no-img')) {
					$('.homepage2 .home-nav-item:first-of-type').addClass('hover-active');
				}
				$that.on('mouseenter', function(){
					// $('.home-nav-item').removeClass('hover-active');
					$that.addClass('hover-active');
				});

				$that.on('mouseleave', function(){
					// $('.home-nav-item').removeClass('hover-active');
					$that.removeClass('hover-active');
				});

				$that.css('background-image', 'none');
			});

		} else {
			$('.homepage2 .home-nav-item').each(function(){
				var $that = $(this),
					bgImg = $that.find('.bg-img-hover').data('bg');
				$that.css('background-image', 'url('+bgImg+')');
			});
		}
	}
	function setWidth() {
		var $elems = $('.homepage2 .home-nav-item span'),
			count = $elems.length,
			elWidth = $(window).outerWidth() / count,
			elHeight = '',
			width = $elems.map( function () {
				return $(this).outerWidth(true);
			}).get(),
			maxWidth = Math.max.apply(null, width);

		if($('.homepage2 .home-nav-items').hasClass('no-nav')) {
			elHeight = $(window).outerHeight() / count;
		} else {
			elHeight = ($(window).outerHeight() - 100)/ count;
		}
		if(maxWidth > elWidth) {
			$('.homepage2 .home-nav-items').addClass('item-full-width');
			$('.homepage2 .home-nav-items').not('.no-nav').css('margin-top', '100px');
			$('.homepage2 .home-nav-item').css('height', ($(window).outerHeight() / 2));
			if((window.mobile || $(window).outerWidth() < 640)) {
				$('.homepage2').css('position', 'static');
			}
			if((window.mobile || $(window).outerWidth() < 640) && $('.home2-footer').length > 0) { 
				$('.home2-footer').css('position', 'relative');
				$('.home2-footer').css('height', '50px');
			}
		} else {
			$('.homepage2 .home-nav-items').removeClass('item-full-width');
			$('.homepage2 .home-nav-items').css('margin-top', 0);
			$('.homepage2 .home-nav-item').css('height', '100%');
			$('.homepage2, .home2-footer').css('position', 'fixed');
		}
	}
		
		
})(jQuery);
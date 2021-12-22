(function($){
	'use strict';
	var $window = $(window);
	var ready = false;


	if(!$('body').hasClass('no-ajax-load')) {
		$window.bind('djaxClick', function(e, data) {
			ready = false;
			$('.page-mask').velocity({ translateX: ['0', '100vw'], translateZ: 0 }, { queue: false, duration: 800, easing: [0.6, 0, 0.3, 1], complete: function(){
				$window.scrollTop(0);
				ready = true;
				$('.body-wrapper').trigger('endTransition');
			}});
		});
		var pageTransition = function(newEl) {
			var oldEl = this;

			if(ready === true) {
				endAnimation(newEl, oldEl);
			} else {
				$('.body-wrapper').on('endTransition', function(){
					endAnimation(newEl, oldEl);
					$('.body-wrapper').off('endTransition');
				});
			}
		};
		
		$('body').djax('.page-wrapper', ['wp-login', '.no-ajax', 'wp-admin', '.doc', '.docx', '.key', '.ppt', '.pptx', '.pps', '.ppsx', '.odt', '.xls', '.xlsx', '.zip', '.rar', '.tar', '.mp3', '.m4a', '.wav', '.mp4', '.mov', '.wmv', '.avi', '.mpg', 'ogv', '.3gp', '.3g2', '.ogg', '.pdf', '.jpg', '.png', '.bmp', '.jpeg', '.gif', 'jp-carousel'], pageTransition);
	}

	var navOverlay = false;
	var navbarHeight = '';
	
	$window.on('contentReady', function(){
		navOverlay = false;
		bindOverlay();

		// logoHeight();
		
		
	});

	$window.on('resize', function(){
		// logoHeight();
	});

	function logoHeight() {
		$('.navbar-large').each(function(){
			var nav = $(this),
				navHeight = nav.find('.columns').height();
			if($window.width() >= 1024) {
				nav.find('.logo-sm img').css('max-height', navHeight);
			} else {
				nav.find('.logo-sm img').css('max-height', "");
			}
		});
	}

	$('body').on('click', '.burger-nav', function(){
		var that = $(this);

		var navbarHeight = $(this).parents('.navbar-top').height();
		$('.navigation-overlay .burger-nav').toggleClass('burger-animation');
		if($('#fb-nav').length > 0) {
			$('#fb-nav').velocity('fadeOut');
		}
		if(navOverlay === false) {
			$('.navigation-overlay .navigation-content').css('margin-top', navbarHeight + 40);
			navOverlay = true;
			$('.navbar-top, .nav-overlay, .navigation-overlay, #fp-nav').velocity('stop');
			$('.burger-nav').addClass('burger-animation');
			$('.nav-overlay').velocity('fadeIn');
			$('.navigation-overlay').velocity('fadeIn', {complete: function(){
			}});
			if($('#fp-nav').length > 0) {
				$('#fp-nav').velocity('fadeOut');
			}
		} else {
			navOverlay = false;
			$('.navbar-top, .nav-overlay, .navigation-overlay, #fp-nav').velocity('stop');
			that.parents('.homepage').find('.navbar-top.hide-for-large .burger-nav').removeClass('burger-animation');
			$('.burger-animation').removeClass('burger-animation');
			if($('#fp-nav').length > 0) {
				$('#fp-nav').velocity('fadeIn');
			}
			$('.nav-overlay').velocity('fadeOut');
			$('.navigation-overlay').velocity('fadeOut',  {complete: function(){
			}});
		}
	});


	function endAnimation(newEl, oldEl) {
		destroyPlugins();
		oldEl.replaceWith(newEl);
		$window.trigger('contentDestroy');
		$window.trigger('contentReady');
		$('.body-wrapper').velocity({opacity: 1}, 400);

		$('.page-mask').velocity({ translateX: ['-100vw', '0'], translateZ: 0 }, { delay:200, queue: false, duration: 800, easing: [0.6, 0, 0.3, 1], complete: function (){
			$window.trigger('contentLoaded');
		} });
	}

	function destroyPlugins() {
		if(typeof $.fn.fullpage.destroy === "function") {
			$.fn.fullpage.destroy('all');
		}

		if($('.player').length > 0) {
			if(typeof $.fn.YTPStop === 'function') {
				$('.player').each(function(){
					if($(this).hasClass('mb_YTPlayer')) {
						$(this).playerDestroy();
					}
				});
			}
		}
	}

	function bindOverlay() {
		var easing = [0.645, 0.045, 0.355, 1];
		$('.navigation-overlay .menu-item-has-children > a').data('djaxExclude', true);
		$('.navigation-overlay .menu-item-has-children > a').prepend('<span class="overlay-children-icon"><i class="">+</i></span> ');
		$('.navigation-overlay .dropdown').prepend('<li class="overlay-back"><a href="#">Back</a></li>');
		$('.navigation-overlay .menu-item-has-children > a').click(function(e){
			e.preventDefault();
			var $that = $(this);
			$that.parent().parent().find('> li > a').velocity({ translateX: -200, opacity: 0}, {display: 'none', easing: easing});
			$('.navigation-overlay .submenu-active').removeClass('submenu-active');
			$that.next('.dropdown').addClass('submenu-active');
			$that.next('.dropdown').find('> li > a').velocity({ translateX: [0, 200], opacity: 1}, {display: 'inline-block', easing: easing});
			var currentText = '';
			if($that.parent().parent().find('> li > a > .overlay-back-header').length > 0) {
				$that.parent().parent().find('> li > a > .overlay-back-header').each(function(){
					currentText += $(this).prop('outerHTML');
				});
			}
			$('.navigation-overlay .social-profiles').velocity({ translateX: -200, opacity: 0}, {display: 'none', easing: easing});
		});
		$('.navigation-overlay').on('click', '.overlay-back', function(e){
			e.preventDefault();
			var $that = $(this);
			$that.find('a').velocity({ translateX: 200, opacity: 0}, {display: 'none', easing: easing});
			$that.siblings().find('a').velocity({ translateX: 200, opacity: 0}, {display: 'none', easing: easing});
			$('.navigation-overlay .submenu-active').removeClass('submenu-active');
			$that.parent().parent().parent().addClass('submenu-active');
			if(!$that.parent().parent().parent().hasClass('dropdown')) {
				$('.navigation-overlay .social-profiles').velocity({ translateX: [0, -200], opacity: 1}, {display: 'inline-block', easing: easing});
			}
			$that.parent().parent().parent().find('> li > a').velocity({translateX : 0, opacity: 1}, {display: 'inline-block', easing: easing });
		});
	}

})(jQuery);
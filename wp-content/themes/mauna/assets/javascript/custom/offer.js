(function($){

	$(window).on('contentReady', function(){
		if($('.offer').length === 0) {
			return;
		}
		prepareHeaders();
	});

	$(window).on('contentLoaded', function(){
		if($('.offer').length === 0) {
			return;
		}
		offerHeaders();

		$('.page-wrapper').addClass('show-additional');

		var scrolled = false;
		var hidden = false;
		$(window).on('scroll', function(){
			if(scrolled === false && $(window).scrollTop() > 20) {
				scrolled = true;
				$('.header-wrapper h3, .circle-decoration').velocity('stop').velocity('transition.slideUpOut');
			} else if(scrolled === true && $(window).scrollTop() <= 20) {
				scrolled = false;
				$('.header-wrapper h3, .circle-decoration').velocity('stop').velocity('transition.slideDownIn');
			}
			if($(window).scrollTop() > $('.offer-content').offset().top - ($('.navbar-top').last().outerHeight() + (document.documentElement.clientWidth * 4 /100) ) && hidden === false) {
				$('.lang-social-menu').parent().velocity({opacity: 0}, 300);
				hidden = true;
			}
			if($(window).scrollTop() <= $('.offer-content').offset().top - ($('.navbar-top').last().outerHeight() + (document.documentElement.clientWidth * 4 /100) ) && hidden === true) {
				$('.lang-social-menu').parent().velocity({opacity: 1}, 300);
				hidden = false;
			}
			if($(window).scrollTop() > $('.offer-content').offset().top -  $('.main-navigation').last().parent().outerHeight()) {
				$('.navbar-top').css('position', 'absolute').css('top', $('.offer-content').offset().top -  $('.main-navigation').last().parent().outerHeight() );
			}

			if($(window).scrollTop() <= $('.offer-content').offset().top - $('.main-navigation').last().parent().outerHeight()) {
				$('.navbar-top').css('position', 'fixed').css('top', 0);
			}
		});
	});
	
	function prepareHeaders() {
		$('.offer-header h3').each(function(){
			var that = $(this);
			var element = that.blast({delimiter: "word", tag: "span"});
			element.each(function(){
				element = $(this);
				element.wrap('<span></span>');
			});
			that.blast(false);
			that.blast({delimiter: "character", tag: "span"});
		});
	}

	function offerHeaders() {
		var elements = $('.offer-header .blast');
		elements = shuffleArray(elements);
		elements.velocity('transition.shrinkIn', {stagger: 70, drag: true, visibility: 'visible'});
	}

	function shuffleArray(array) {
		for (var i = array.length - 1; i > 0; i--) {
			var j = Math.floor(Math.random() * (i + 1));
			var temp = array[i];
			array[i] = array[j];
			array[j] = temp;
		}
		return array;
	}

})(jQuery);
(function($){
	'use strict';
	$(window).on('contentReady', function(){
		prepareHeaders();
	});

	$(window).on('contentLoaded', function(){
		animateHeaders();
	});

	$(window).on('aboutSlideChange', function(){
		animteAboutHeader();
	});

	function prepareHeaders() {
		$('.animate-header').each(function(){
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


	function animateHeaders() {
		if($('.page-wrapper > .about').length > 0) {
			return;
		}
		if($('.animate-header').length > 0) {
			$('.animate-header').each(function(){
				var elements = $('.blast-root .blast');
				elements = shuffleArray(elements);
				var c = 0;
				$('.dl-show').removeClass().addClass('blast');
				elements.each(function(i, el){
					$(el).addClass('dl-show dl-'+c);
					c++;
					if(c > 8) {
						c = 0;
					}
				});

				if($('.decoration').length > 0) {

					$('.decoration svg').velocity('transition.expandIn', {delay: 300, visibility: 'visible', complete: function(){
						$('.page-wrapper').addClass('show-additional');
					}});
				} else {
					$('.page-wrapper').addClass('show-additional');
				}
				if($('.open-off-canvas').length > 0) {
					var btnWidth = $('.open-off-canvas').height();
					$('.home-header .header-wrapper').css('padding', btnWidth + 30);
				}
			});
		} else {
			$('.page-wrapper').addClass('show-additional');
				if($('.decoration').length > 0) {
				$('.decoration svg').velocity('transition.expandIn', {delay: 300, visibility: 'visible', complete: function(){
						
				}});
			}
		}
		
	}

	function animteAboutHeader() {
		var elements = $('.active .blast');
		elements = shuffleArray(elements);
				var c = 0;
				$('.dl-show').removeClass().addClass('blast');
				elements.each(function(i, el){
					$(el).addClass('dl-show dl-'+c);
					c++;
					if(c > 8) {
						c = 0;
					}
				});

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
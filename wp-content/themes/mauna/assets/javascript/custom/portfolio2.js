(function($){
	$(window).on('contentReady', function(){

		if($('.portfolio2').length === 0) {
			return;
		}
		portfolioSwipebox2();

		$(window).on('resize', function(){
			resizeImages();
		});

		resizeImages();

		var slides = 0,
			loop = '',
			slidesPerView = '';

		if($('.portfolio-carousel2 .portfolio-item2').length == 1) {
			loop = false;
			slidesPerView = 1;
		} else {
			loop = true;
			slidesPerView = 'auto';
		}
		
		function portfolioSwipebox2() {
			$('.portfolio-carousel2').on('click', '.swipebox2', function(e){
				e.preventDefault();
				var images = [];
				$(this).parent().find('a').not('.single-portfolio-item').each(function(){
					images.push({href: this.href, title: this.title});
				});
				if(images.length > 0) {
					$.swipebox(images);
				}
			});
		}

		var mySwiper2 = new Swiper('.portfolio-carousel2', {
			speed: 900,
			slidesPerView: slidesPerView,
			centeredSlides: true,
			freeMode: false,
			breakpoints: {
				1024: {
					freeMode: true
				}
			},
			paginationType: 'progress',
			pagination: '.swiper-pagination',
			
			loop: loop,
			direction: 'horizontal',
			mousewheelControl: true,
			grabCursor: true,
			slideClass: 'portfolio-item2',
			keyboardControl: true,
			nextButton: '.portfolio2 .portfolio-slide-next',
			prevButton: '.portfolio2 .portfolio-slide-prev',
			onSlideChangeStart: function(swiper) {
				var caption = $('.portfolio-item2.swiper-slide-active a').attr('title');
				if(caption !== undefined && caption !== '') {
					$('.portfolio2-filters .menu-wrapper .img-caption').remove();
					$('.portfolio2-filters .menu-wrapper').prepend('<div class="img-caption">'+caption+'</div>');
				}
			},
			onTransitionStart: function(swiper) {
				$('.active').removeClass('active');
				var active = $('.swiper-slide-active').data('swiper-slide-index');
				$('.portfolio-item2[data-swiper-slide-index="'+active+'"]').addClass('active');
			},
		});


		function resizeImages() {
			windowHeight = $(window).height();
			if($('.portfolio2-filters').length > 0) {
				windowHeight = windowHeight-60;
			}
			$('.portfolio-item2 img').each(function(){
				var that = $(this);
				height = that.attr('height');
				width = that.attr('width');
				newHeight = windowHeight;
				newWidth = newHeight * width / height;
				that.height(Math.round(newHeight));
				that.width(Math.round(newWidth));
			});

			if(mySwiper2) {
				mySwiper2.update(true);
			}
		}
	});
})(jQuery);
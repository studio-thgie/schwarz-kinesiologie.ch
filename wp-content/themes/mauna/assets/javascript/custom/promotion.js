(function($) {
	$.fn.unveil = function(threshold, callback) {
		var $w = $(window),
			th = threshold || 0,
			retina = window.devicePixelRatio > 1,
			attrib = retina? "data-src-retina" : "data-src",
			images = this,
			loaded;

		this.one("unveil", function() {
			var img = this.children[0].children[0];
			var source = img.getAttribute(attrib);
			source = source || img.getAttribute("data-src");
			if (source) {
				img.setAttribute("src", source);
				img.setAttribute('class', 'ready-to-load');
				$(window).trigger('readyToLoad');
				if (typeof callback === "function") callback.call(this);
			}
		});
		return this;
	};
})(window.jQuery || window.Zepto);

(function($){
	$(window).on('contentLoaded', function(){
		if($('.promotion-news').length === 0) {
			return;
		}
		resizeImages();
		var wrapperWidth = 0;

		var arrowPrev = $('.portfolio-slide-prev');
		var arrowNext = $('.portfolio-slide-next');
		var nextShow = false;
		var prevShow = false;
		$('.promotion-item').each(function(){
			var item = $(this);
			var itemWidth = item.width();
			wrapperWidth = wrapperWidth + itemWidth;
		});

		$('.promotion-inner').width(wrapperWidth);
		$('.no-link').click(function(e){
			e.preventDefault();
		});

		$(window).on('resize', function(){
			resizeImages();
			checkArrow();
		});


		$(window).on('readyToLoad', function(){
			$('.ready-to-load').imagesLoaded().progress(function(instance, image){
				image.img.className = 'loaded-image';
				image.img.parentElement.className += ' loaded-images';
			});
		});
		$('.promotion-item').unveil();
		var images = $('.promotion-item'),
			$w = $(window),
			th = 200,
			attrib = 'data-src';


		var mySwiper = new Swiper('.promotion-news-carousel', {
			speed: 400,
			scrollbarHide: true,
			setWrapperSize: true,
			slidesPerView: 'auto',
			mousewheelControl: true,
			grabCursor: true,
			onInit: function() {
				promotionUnveil(-($(window).width()/3));
			},
			onSetTranslate: function(swiper, translate) {
				promotionUnveil(translate);
				// console.log(translate);
			},
			onProgress: function(swiper, progress) {
				checkArrow();
				if(progress == 1) {
					promotionUnveil(swiper.translate-1200);
				}
			},
			freeMode: true,
			nextButton: '.portfolio-slide-next',
			prevButton: '.portfolio-slide-prev',
		});


		function promotionUnveil(translate) {
			var inview = images.filter(function() {
				var $e = $(this);
				if ($e.is(":hidden")) return;

				var wt = translate*-1,
					wb = wt + ($w.width() / 3)*2,
					et = $e.position().left,
					eb = et + $e.width();
				return wb >= et;
			});
			loaded = inview.trigger("unveil");
			images = images.not(loaded);
		}
		function resizeImages() {
			windowHeight = $(window).height();
			var containerWidth = 0;
			$('.promotion-item img').each(function(){
				var that = $(this);
				height = that.attr('height');
				width = that.attr('width');
				newHeight = windowHeight / 2;
				newWidth = newHeight * width / height;
				that.height(Math.round(newHeight));
				that.width(Math.round(newWidth));
				containerWidth += newWidth;
			});

			$('.promotion-inner').width(containerWidth+1);
			if(mySwiper) {
				mySwiper.update(true);
			}
		}

		function checkArrow() {
			var mySwiper = $('.promotion-news-carousel').data('swiper');
			
			if(typeof mySwiper == 'object') {
			if(mySwiper.progress === 0) {
				arrowPrev.css('display', 'none');
				prevShow = false;
			} else if(prevShow === false) {
				arrowPrev.css('display', 'block');
				prevShow = true;
			}
			if(mySwiper.size === mySwiper.virtualSize) {
				arrowNext.css('display', 'none');
				nextShow = false;
			}

			if(mySwiper.progress === 1) {
				arrowNext.css('display', 'none');
				nextShow = false;
			} else if(nextShow === false) {
				arrowNext.css('display', 'block');
				nextShow = true;
			}
			}

		}

		checkArrow();
		$('.portfolio-slide-next').on('click', function(){
			movePortfolioRight();
		});

		$('.portfolio-slide-prev').on('click', function(){
			movePortfolioLeft();
		});
		$(document).on('keydown', function(e){
			if (e.originalEvent) e = e.originalEvent;
			var kc = e.keyCode || e.charCode;
			if (kc === 39 || kc == 40) movePortfolioRight();
			if (kc === 37 || kc == 38) movePortfolioLeft();
		});

		$(window).on('resize', function(){
			// mySwiper.update();	
		});

		function movePortfolioRight() {
			var newTranslate = mySwiper.getWrapperTranslate()-($w.width()/2);
			if(newTranslate*-1 <= mySwiper.virtualSize-mySwiper.width) {
				mySwiper.setWrapperTranslate(newTranslate);
			} else {
				mySwiper.setWrapperTranslate((mySwiper.virtualSize-mySwiper.width)*-1);
			}
		}

		function movePortfolioLeft() {
			var newTranslate = mySwiper.getWrapperTranslate()+($w.width()/2);
			if(newTranslate*-1 >= 0) {

				mySwiper.setWrapperTranslate(newTranslate);
			} else {
				mySwiper.setWrapperTranslate(0);
			}
		}
	});
})(jQuery);
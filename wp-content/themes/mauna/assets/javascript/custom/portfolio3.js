(function($){
	$(window).on('contentReady', function(){

		if($('.portfolio3').length === 0) {
			return;
		}

		initMasonry();

		function initMasonry() {
			var $grid = $('.portfolio3-masonry');
			$grid.isotope({
				itemSelector: '.portfolio-item3',
				columnWidth: '.portfolio-grid-sizer',
				gutter: 0,
				percentPosition: true,
				hiddenStyle: {
					opacity: 0,
				},
				visibleStyle: {
					opacity: 1,
				},
				transitionDuration: 0,
			});

			$grid.imagesLoaded().done( function() {
				$grid.isotope('layout');
				$('.portfolio3 .portfolio-item3').addClass('item-visible');
				$grid.isotope('layout');
			});
		}
		var canClick = true;
		$('.portfolio3').on('click', '.portfolio-load-more', function(e){
			e.preventDefault();
			if(canClick === false) {
				return;
			}
			canClick = false;
			var ready = false;
			
			var $that = $(this);
			var $parent = $that.parent();
			$parent.velocity({opacity: 0}, 400, function(){
				ready = true;
				$('.page-wrapper').trigger('galleryLoadMore');
			});
			$.get(this.href, function(response){
				if(ready === true) {
					$that.remove();
					insertContent(response);
				} else {
					$('.page-wrapper').on('galleryLoadMore', function(){
						$that.remove();
						insertContent(response);
					});
				}
			});
		});

		function insertContent(response) {
			var $grid = $('.portfolio3-masonry');
			var loadMore = $(response).find('.portfolio-load-more-wrapper').html();
			response = $(response).find('.portfolio3-masonry').html();
			var $response = $(response);
			$grid.append($response);
			$('.page-wrapper').off('galleryLoadMore');

			$grid.imagesLoaded().done( function() {
				$grid.isotope('appended', $response);
				$('.portfolio3 .portfolio-item3').not('.item-visible').addClass('item-visible');
				if(typeof loadMore === "undefined") {
					$('.portfolio-load-more-wrapper').remove();
				} else {
					$('.portfolio-load-more-wrapper').html(loadMore).velocity({opacity: 1});
				}
				canClick = true;
			});

		}
	});
})(jQuery);
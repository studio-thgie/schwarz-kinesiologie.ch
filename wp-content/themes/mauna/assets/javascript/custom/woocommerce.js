(function($){
	'use strict';
	
	$(document).ready(function(){
		$('body').on('click', 'input.minus', function(e) {
			var current = parseInt(jQuery(this).parent().find('.input-text.qty').val(), 10);
			if (current > 1) {
				var qty = jQuery(this).parent().find('.input-text.qty');
				qty.val(current-1).change();
			}
		});

		$('body').on('click', 'input.plus', function(e) {
			var current = parseInt(jQuery(this).parent().find('.input-text.qty').val(), 10);
			var qty = jQuery(this).parent().find('.input-text.qty');
			qty.val(current+1).change();

		});

		$('body').on('added_to_cart', function(e) {
			$('.add-to-cart-button').each(function(){
				var that = $(this);
				var text = that.text();
				var addedText = that.data('added');
				if(that.hasClass('added')) {
					that.text(addedText);
					setTimeout(function() {
						that.removeClass('added');
						that.text(text);
					}, 3000);
				}
			});

			$('.cart-icon').velocity({ opacity:0, translateY: -10}, { easing: [0.23, 1, 0.32, 1] }).velocity({ opacity:1, translateY: 0});
			if(mobile || ipad || $(window).width() < 991) {
				$('#mobile-added-to-cart').show(0).velocity({opacity: 1}).delay(2000).velocity({opacity:0});
			}
		});
		$('.cart-icon').click(function(){
			$('.cart-offcanvas').addClass('show-cart-offcanvas');
		});
		$('.cart-offcanvas-close').click(function(){
			$('.cart-offcanvas').removeClass('show-cart-offcanvas');
		});
	});
})(jQuery);
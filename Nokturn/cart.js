$(document).ready(function() {

	$('.js-product-remove').click(function(e) {
		e.preventDefault();
		var $cartProductRemoveButton = $(e.currentTarget);
		var $cartProductRow = $cartProductRemoveButton.closest('.js-cart-product-row');
		var productId = $cartProductRow.data('product-id');
		var quantity = $cartProductRow.data('product-quantity');
		var productTotalPrice = $cartProductRow.data('product-total-price');
		var $cartFinalPrice = $('.js-cart-final-price');
		var cartFinalPrice = $cartFinalPrice.data('cart-final-price');

		$.ajax({
			type: 'POST',
			url: 'removeFromCart.php',
			data: {
				'productId': productId,
				'quantity': quantity
			},
			success: function(data) {
				$cartProductRow.remove();
				$cartFinalPrice.html(cartFinalPrice - productTotalPrice);

				showSuccessAlert(data);
			},
			error: function(data) {
				showErrorAlert(data.responseText);
			}
		});
	});

	$('.js-buy-from-cart').click(function(e) {
		e.preventDefault();
		var $cart = $('.js-cart');
		var $cartHeader = $('.js-cart-header');
		var $cartTable = $cart.find('table');

		$.ajax({
			type: 'POST',
			url: 'buyFromCart.php',
			success: function(data) {
				$cartHeader.html(data);
				$cartTable.remove();
			},
			error: function(data) {
				showErrorAlert(data.responseText);
			}
		});
	});
});
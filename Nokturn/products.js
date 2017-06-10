$(document).ready(function() {

	$('.js-product-buy').click(function(e) {
		e.preventDefault();
		var $productRow = $(e.currentTarget).closest('.js-product-row');
		var productId = $(e.currentTarget).data('product-id');
		var quantity = $productRow.find('.js-product-quantity-select').val();

		if(!quantity) {
			quantity = 1;
		}

		$.ajax({
			type: 'POST',
			url: 'addToCart.php',
			data: {
				'productId': productId,
				'quantity': quantity
			},
			success: function(data) {
				var $productQuantity = $productRow.find('.js-product-quantity');
				var $productQuantitySelect = $productRow.find('.js-product-quantity-select');
				var currentQuantity = $productQuantity.html();
				var newQuantity = currentQuantity - quantity;

				$productQuantity.html(newQuantity);

				$productQuantitySelect.find('option').each(function(key, option) {
					if($(this).val() > newQuantity) {
						$(this).remove();
					}
				});

				showSuccessAlert(data);
			},
			error: function(data) {
				showErrorAlert(data.responseText);
			}
		});
	});
});
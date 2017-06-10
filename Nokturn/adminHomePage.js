showNewProductRow();

function showNewProductRow() {
	var $newProductRow = $('.js-new-product-form');
	var $cloneOfNewProductRow = $newProductRow.clone();

	$newProductRow.before($cloneOfNewProductRow);
	$cloneOfNewProductRow.removeClass('js-new-product-form').show();
}

$(document).ready(function() {
	function bindEditProduct(e) {
		e.preventDefault();
		var $currentForm = $(e.currentTarget).parent();

		$.ajax({
			type: 'POST',
			url: 'editProduct.php',
			data: $currentForm.serialize(),
			success: function() {
				showSuccessAlert('Success!');
			},
			error: function() {
				showErrorAlert('Try again!');
			}
		});
	}

	function bindAddProduct(e) {
		e.preventDefault();
		var $currentForm = $(e.currentTarget).parent();

		$.ajax({
			type: 'POST',
			url: 'addProduct.php',
			data: $currentForm.serialize(),
			success: function(result) {
			//	console.log(result);
				$currentForm.find('input[name="id"]').val(result);
				$currentForm.find('.js-add-product').removeClass('js-add-product').addClass('js-edit-product').unbind('click').click(function(e) {
					bindEditProduct(e);
				});
				// dodac przycisk delete i zbindowac

				showSuccessAlert('Success!');
				showNewProductRow();
			},
			error: function(data) {
				console.log(data);
				showErrorAlert(data.responseJSON, 10000);
			}
		});
	}

	$('.js-edit-product').click(function(e) {
		bindEditProduct(e);
	});

	$('.js-add-product').click(function(e) {
		bindAddProduct(e);
	});
});
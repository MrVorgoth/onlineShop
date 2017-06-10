<div class="row">
	<div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
		<div class="product">
			<button class="btn btnSize" onclick="document.getElementById('addProductAction').style.display='none'
			document.getElementById('changeContentSize').style.height='600px'">Hide !!!</button>
			<button class="btn btnSize" onclick="document.getElementById('addProductAction').style.display='block'
			document.getElementById('changeContentSize').style.height='850px'">Show !!!</button>

			<div id="addProductAction">
				<form method="POST">
				<h3>Input product data</h3>
				<input type="text" value="<?php
					if(isset($_SESSION['f1_name'])) {
						echo $_SESSION['f1_name'];
						unset($_SESSION['f1_name']);
					}
				?>" name="f1_name" class="form-control" placeholder="Name:">
				<?php
					if(isset($_SESSION['e1_name'])) {
						echo '<div class="error">'.$_SESSION['e1_name'].'</div>';
						unset($_SESSION['e1_name']);
					}
				?>					
				<input type="text" value="<?php
					if(isset($_SESSION['f1_price'])) {
						echo $_SESSION['f1_price'];
						unset($_SESSION['f1_price']);
					}
				?>" name="f1_price" class="form-control" placeholder="Price:">
				<?php
					if(isset($_SESSION['e1_price'])) {
						echo '<div class="error">'.$_SESSION['e1_price'].'</div>';
						unset($_SESSION['e1_price']);
					}
				?>
				<input type="text" value="<?php
					if(isset($_SESSION['f1_quantity'])) {
						echo $_SESSION['f1_quantity'];
						unset($_SESSION['f1_quantity']);
					}
				?>" name="f1_quantity" class="form-control" placeholder="Quantity:">
				<?php
					if(isset($_SESSION['e1_quantity'])) {
						echo '<div class="error">'.$_SESSION['e1_quantity'].'</div>';
						unset($_SESSION['e1_quantity']);
					}
				?>
				<input type="text" value="<?php
					if(isset($_SESSION['f1_category'])) {
						echo $_SESSION['f1_category'];
						unset($_SESSION['f1_category']);
					}
				?>" name="f1_category" class="form-control" placeholder="Category:">
				<?php
					if(isset($_SESSION['e1_category'])) {
						echo '<div class="error">'.$_SESSION['e1_category'].'</div>';
						unset($_SESSION['e1_category']);
					}
				?>
				<input type="text" value="<?php
					if(isset($_SESSION['f1_image_url'])) {
						echo $_SESSION['f1_image_url'];
						unset($_SESSION['f1_image_url']);
					}
				?>" name="f1_image_url" class="form-control" placeholder="Image URL:">
				<?php
					if(isset($_SESSION['e1_image_url'])) {
						echo '<div class="error">'.$_SESSION['e1_image_url'].'</div>';
						unset($_SESSION['e1_image_url']);
					}
				?>
				<input type="text" value="<?php
					if(isset($_SESSION['f1_description'])) {
						echo $_SESSION['f1_description'];
						unset($_SESSION['f1_description']);
					}
				?>" name="f1_description" class="form-control" placeholder="Description:">
				<?php
					if(isset($_SESSION['e1_description'])) {
						echo '<div class="error">'.$_SESSION['e1_description'].'</div>';
						unset($_SESSION['e1_description']);
					}
				?>
				<input type="submit" value="Submit" class="btn btn-primary">
			</form>
			</div>
		</div>
	</div>
	<div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
		<div class="product">
			<button class="btn btnSize" onclick="document.getElementById('editProductAction').style.display='none'
			document.getElementById('changeContentSize').style.height='600px'">Hide !!!</button>
			<button class="btn btnSize" onclick="document.getElementById('editProductAction').style.display='block'
			document.getElementById('changeContentSize').style.height='850px'">Show !!!</button>
			
			<div id="editProductAction">
				<form method="POST">
				<h3>Insert product's name you want to change:</h3>
				<input type="text" value="<?php
					if(isset($_SESSION['f2_old_name'])) {
						echo $_SESSION['f2_old_name'];
						unset($_SESSION['f2_old_name']);
					}
				?>" name="f2_old_name" class="form-control" placeholder="Name:">
				<?php
					if(isset($_SESSION['e2_old_name'])) {
						echo '<div class="error">'.$_SESSION['e2_old_name'].'</div>';
						unset($_SESSION['e2_old_name']);
					}
				?>

				<h3>Edit product data</h3>
				<input type="text" value="<?php
					if(isset($_SESSION['f2_name'])) {
						echo $_SESSION['f2_name'];
						unset($_SESSION['f2_name']);
					}
				?>" name="f2_name" class="form-control" placeholder="Name:">
				<?php
					if(isset($_SESSION['e2_name'])) {
						echo '<div class="error">'.$_SESSION['e2_name'].'</div>';
						unset($_SESSION['e2_name']);
					}
				?>					
				<input type="text" value="<?php
					if(isset($_SESSION['f2_price'])) {
						echo $_SESSION['f2_price'];
						unset($_SESSION['f2_price']);
					}
				?>" name="f2_price" class="form-control" placeholder="Price:">
				<?php
					if(isset($_SESSION['e2_price'])) {
						echo '<div class="error">'.$_SESSION['e2_price'].'</div>';
						unset($_SESSION['e2_price']);
					}
				?>
				<input type="text" value="<?php
					if(isset($_SESSION['f2_quantity'])) {
						echo $_SESSION['f2_quantity'];
						unset($_SESSION['f2_quantity']);
					}
				?>" name="f2_quantity" class="form-control" placeholder="Quantity:">
				<?php
					if(isset($_SESSION['e2_quantity'])) {
						echo '<div class="error">'.$_SESSION['e2_quantity'].'</div>';
						unset($_SESSION['e2_quantity']);
					}
				?>
				<input type="text" value="<?php
					if(isset($_SESSION['f2_category'])) {
						echo $_SESSION['f2_category'];
						unset($_SESSION['f2_category']);
					}
				?>" name="f2_category" class="form-control" placeholder="Category:">
				<?php
					if(isset($_SESSION['e2_category'])) {
						echo '<div class="error">'.$_SESSION['e2_category'].'</div>';
						unset($_SESSION['e2_category']);
					}
				?>
				<input type="text" value="<?php
					if(isset($_SESSION['f2_image_url'])) {
						echo $_SESSION['f2_image_url'];
						unset($_SESSION['f2_image_url']);
					}
				?>" name="f2_image_url" class="form-control" placeholder="Image URL:">
				<?php
					if(isset($_SESSION['e2_image_url'])) {
						echo '<div class="error">'.$_SESSION['e2_image_url'].'</div>';
						unset($_SESSION['e2_image_url']);
					}
				?>
				<input type="text" value="<?php
					if(isset($_SESSION['f2_description'])) {
						echo $_SESSION['f2_description'];
						unset($_SESSION['f2_description']);
					}
				?>" name="f2_description" class="form-control" placeholder="Description:">
				<?php
					if(isset($_SESSION['e2_description'])) {
						echo '<div class="error">'.$_SESSION['e2_description'].'</div>';
						unset($_SESSION['e2_description']);
					}
				?>
				<input type="submit" value="Submit" class="btn btn-primary">
			</form>
			</div>
		</div>
	</div>
	<div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
		<div class="product">
			<button class="btn btnSize" onclick="document.getElementById('deleteProductAction').style.display='none'
			document.getElementById('changeContentSize').style.height='600px'">Hide !!!</button>
			<button class="btn btnSize" onclick="document.getElementById('deleteProductAction').style.display='block'
			document.getElementById('changeContentSize').style.height='850px'">Show !!!</button>
			
			<div id="deleteProductAction">
				<form method="POST">
				<h3>Delete product</h3>
				<input type="text" value="<?php
					if(isset($_SESSION['f3_name'])) {
						echo $_SESSION['f3_name'];
						unset($_SESSION['f3_name']);
					}
				?>" name="f3_name" class="form-control" placeholder="Name:">
				<?php
					if(isset($_SESSION['e3_name'])) {
						echo '<div class="error">'.$_SESSION['e3_name'].'</div>';
						unset($_SESSION['e3_name']);
					}
				?>
				<input type="submit" value="Submit" class="btn btn-primary">
			</form>
			</div>
		</div>
	</div>
</div>
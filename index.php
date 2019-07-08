<!DOCTYPE html>
<html>
<head>
	<title>Sample</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

	<?php require_once 'action.php'; ?>

	<div class="container">
		<div class="row mt-5">

			<?php
			if(!empty($products)) {
				foreach($products as $value) {
			?>

			<div class="col-12">
				<div class="d-flex flex-wrap align-items-center mb-5 item">
					<div class="image-wrap mr-5">
						<img src="<?= $value['image']; ?>" class="image">
					</div>
					<h5 class="name mr-5 mb-0"><?= $value['name']; ?></h5>
					<p class="description mb-0 mr-5"><?= $value['description']; ?></p>
					<div class="price mr-5" data-price="<?= $value['price']; ?>00"><?= $value['price']; ?> руб.</div>
					<div class="quantity-wrap">
						<input type="number" min="1" class="form-control quantity" value="1">
					</div>
				</div>
			</div>

			<?php
				}
			}
			?>

			<div class="col-12">
				<button class="btn btn-danger mb-4" id="btnPay">Оплатить</button>
			</div>
		</div>
	</div>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$("#btnPay").on("click", function() {
				var amount = 0, items = [];
				$(".item").each(function() {
					amount += $(this).find(".quantity").val() * $(this).find(".price").attr("data-price");
					items.push({
		                "Name": $(this).find(".name").text(),
		                "Price": parseInt($(this).find(".price").attr("data-price")),
		                "Quantity": parseInt($(this).find(".quantity").val()),
		                "Amount": $(this).find(".quantity").val() * $(this).find(".price").attr("data-price"),
		                "Tax": "vat10"
		            });
				});

				var data = {
					"TerminalKey": "TinkoffBankTest",
					"Amount": amount,
					"OrderId": 2241,
					"Description": "lorem ipsum dolor sit amet",
					"Receipt": {
				        "Email": "a@test.ru",
				        "Phone": "+79031234567",
				        "Taxation": "osn",
				        "Items": items
				    }
				};

				$.ajax({
					url: "https://securepay.tinkoff.ru/v2/Init",
					dataType: "json",
					type: "POST",
					contentType: "application/json",
					data: JSON.stringify(data),
					success: function(result) {
						console.log(result);
						window.location.href = result.PaymentURL;
					}
				});
			});
		});
	</script>

</body>
</html>
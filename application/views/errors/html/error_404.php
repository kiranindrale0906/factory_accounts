<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
 <html lang="en" class="bg_white">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="icon" type="image/png" sizes="16x16" href="<?= BASE_URL ?>assets/core/images/common/favicon.ico">
		<title>404 Page Not Found</title>
		<link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>assets/core/plugins/bootstrap-4.3.1/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>assets/core/plugins/fontawesome-pro-5.6.1-web/css/all.css">
		<link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>assets/core/css/style.css">
	</head>
	<body class="bg_white">
		<main class="error_page d-flex align-items-center">
			<div class="container">
				<div class="row">
					<div class="col-md-6 col-sm-12 mx-auto text-center">
						<div class="error_div">
							<img src="<?= BASE_URL ?>assets/core/images/common/404.png" class="img-fluid mx-auto">
							<h1 class="text-center mt-3 light_cyan">Error 404</h1>
							<h4 class="text-center medium">Page not Found</h4>
							<div class="btn_group">
								<a class="btn btn-lg btn_black" href="<?= BASE_URL ?>"><i class="fal fa-long-arrow-left"></i> Back to Home</a>
							</div>
						</div>					
					</div>
				</div>
			</div>
		</main>
	</body>
</html>
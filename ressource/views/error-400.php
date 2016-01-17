<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Furez API Framework - 404</title>
		<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="ressource/css/style.css">
		<link rel="shortcut icon" type="image/x-icon" href="ressource/img/favicon.ico">
	</head>
	<body>
		<div class="container">
			<header>
				<div class="row">
					<div class="col-xs-12">
						<div class="page-header text-center">
							<img src="ressource/img/logo.png" alt="Furez logo" height="250px">
							<div>
								<em>Furez API Framework<br>
								The game is not about becoming somebody, it's about becoming nobody.</em>
							</div>
						</div>
					</div>
				</div>
			</header>

			<div class="row">
				<div class="col-xs-12">
					<div class="text-center">
						<h1 class="error404">Error 404!</h1>
						<div class="well">
							Current API Url = 
									<a href="<?php echo($_SESSION['apiurl']) ?>" target="_blank"><?php echo($_SESSION['apiurl']) ?></a>
							<div class="form-group">
								<h4>Furez Interface can't succed to call the API. Please check your config or if the API is well upload.</h4>
							</div>
							<a class="btn btn-success" href="<?php echo($this->router->generate('config')) ?>">Config</a>
						</div>
					</div>
				</div>
			</div>

		</div>
	</body>
</html>

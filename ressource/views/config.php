<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Furez API Framework - Config</title>
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
					<a class="btn btn-info btn-small" href="<?php echo($this->router->generate('index')) ?>">Interface</a>
                    <a class="btn btn-danger btn-small" href="<?php echo($this->router->generate('reloadAll')) ?>">Remove Cookies and Session</a>
                </div>
			</div>

			<section>
				<div class="row">
					<div class="col-xs-12">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h3 class="panel-title">Config Info</h3>
							</div>
							<div class="panel-body">
								<div class="form-group">
									<button class="btn btn-success btn-add" data-toggle="modal" data-target="#addAPI">Add new API</button>
								</div>
								<h2>Current API</h2>
									<div class="row text-center">
										<div class="col-xs-4"></div>
										<div class="col-xs-4">
											<?php if(isset($current_api)) : ?>
												<div class="thumbnail" data-key="current">
			      									<img class="image" src="<?php echo($current_api->image) ?>" alt="">
			      									<div class="caption">
			      										<h3 class="website"><?php echo($current_api->website) ?></h3>
			      										<p><b>Url:</b> <a href="<?php echo($current_api->url) ?>" class="url"><?php echo($current_api->url) ?></a></p>
			      										<p><b>Last update:</b> <?php echo($current_api->lastupdate) ?></p>
			      										<p><b>Version:</b> <?php echo($current_api->version) ?></p>
												        <div>
												        	<a href="#" class="btn btn-warning btn-edit" role="button">Edit</a>
												        </div>
											      	</div>
											    </div>
										    <?php else : ?>
										    	<p>no api</p>
										    <?php endif; ?>
										</div>
										<div class="col-xs-4"></div>
									</div>
								<hr>
								<h2>Former API</h2>
								<div class="table-responsive">          
									<table class="table">
										<thead>
											<tr>
												<th>Website</th>
												<th>Image</th>
												<th>URL</th>
												<th>Last Update</th>
												<th>Version</th>
												<th>Option</th>
											</tr>
										</thead>
										<tbody>
											<?php
												if($group) {
													for ($i = 0; $i < $group->count(); $i++) {
														if ((string)$group[$i]->attributes()->current != "true") {
															echo(
																"<tr data-key='" . $i . "'>
																<td class='website'>" . $group[$i]->website . "</td>
																<td><img class='image' src='" . $group[$i]->image . "' alt='' class='img-responsive'></td>
																<td><p class='url'><a href='" . $group[$i]->url . "'>" . $group[$i]->url . "</a></p></td>
																<td><p>" . $group[$i]->lastupdate . "</p></td>
																<td><p>" . $group[$i]->version . "</p></td>
																<td>
																	<a href='" . $this->router->generate('selectNewApi') . "?index=" . $i . "' class='btn btn-primary'>Select</a>
																	<a href='#' class='btn btn-warning btn-edit'>Edit</a>
																</td>
															</tr>"
															);
														}
													}
												}
											?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>

		<div class="modal fade" id="addAPI" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">API</h4>
					</div>
					<form class="form" action="<?php echo($this->router->generate('handleApi')) ?>" method="POST">
						<div class="modal-body">
								<div class="form-group">
									<label for="website">Website:</label>
									<input type="text" id="website" required name="website" class="form-control" placeholder="ex: Google, Facebook, YourTarget">
								</div>
								<div class="form-group">
									<label for="image">Image (external url):</label>
									<input type="text" id="image" required name="image" class="form-control" placeholder="ex: http://yourdomain.com/image/01.png">
								</div>
								<div class="form-group">
									<label for="url">Url:</label>
									<input type="text" id="url" required name="url" class="form-control" placeholder="ex: http://yourtarget.com/image/furez_api.php">
								</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							<input type="hidden" id="edit" name="edit" value="false">
							<input type="submit" class="btn btn-success" value="Validate">
						</div>
					</form>
				</div>
			</div>
		</div>

		<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
		<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="ressource/js/config.js"></script>
	</body>
</html>

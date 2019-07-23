<!DOCTYPE html>
<html lang="ru">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

		<title><?=$title ?></title>
		<meta name="description" content="Electronics store, Hardware store, Buy Laptops, Buy Monitors, Buy Smarthones, Buy TVSs">
		<script src="assets/vendor/jquery/jquery.min.js"></script>
		<script src="assets/bootstrap3/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="assets/bootstrap3/css/bootstrap.min.css">
		<link rel="stylesheet" href="assets/bootstrap3/css/bootstrap-theme.min.css">
		<link rel="stylesheet" href="assets/css/style.css?v=2">
	
		
	
		

	</head>
	<body>
	<div class="container">
			<div class="row">
				<header><nav class="navbar-expand-sm navbar-dark first-menu">
							  <div class="navbar-collapse">
							
					<?php if (isset($_SESSION["auth"])){
								echo "<span class=\"navbar-brand\">Hello, $_SESSION[login]</span>
								<span class=\"navbar-brand\">Your status: $_SESSION[status]</span>";
								}
								?>
								
								</div>
						</nav>
					<nav class="navbar-expand-sm navbar-blue">
						<ul class="nav nav-pills">
						<li><a class="btn btn-primary" href="index.php">HOME</a></li>
						
							<?php $nav = new Menu('category');
								echo $nav->showMenu();
							?>
							<a class="btn btn-primary float-right" href="basket.php">Your Basket</a>
						</ul>
						
					</nav>
							<nav class="navbar-expand-sm navbar-dark bg-dark">
							  <div class="collapse navbar-collapse">
								<ul class="nav nav-tabs">
      
									<?php 
									if (isset($_SESSION["auth"])){
										include("priveHeader.php");
										if ($_SESSION["status"] == "admin")
										include("adminHeader.php");  
									}
									else include("publicHeader.php");  
									
									?>
									
								</ul>
								
							  </div>
							</nav>
								 


						
				</header>
				<main>
				<h1><?=$title ?></h1>
				
					
					<?php include 'info.php';?>		
					
					<?=$content?>
				</div>
				<div class="pagination_class">
				<?php 
							if (!(empty($pagination))){
								echo '<nav> <ul class="pagination">';
								echo $pagination;
								echo '</ul></nav>';
						}
					?>
				</div>
				
						 <?php 
						 include 'footer.php';?>
				</main>
			</div>
		
	</body>
</html>
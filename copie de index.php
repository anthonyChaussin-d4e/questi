<!-- Temps passé 2h -->
<?php 
error_reporting(0);
ini_set('display_errors', 0);
if(isset($_POST)){

$total = 0;
    $vars = array_values($_POST);
   
    
    
    $etape1 = $vars[0] * $vars[1] * $vars[4] * 253;
    $etape2 = ($vars[1] * $vars[3] * $vars[0] * 253)/ $vars[5];
    $etape3 = ($vars[3] * $vars[1] * $vars[0] * 253) / ($vars[6] * $vars[7]);
    $etape4 = $vars[8] * 5.95 * $vars[1] * 253;
    

    
    $total = $etape1 + $etape2 + $etape3 + $etape4;
    
    $total = $total / 1000000;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="css/bootstrap.min.css">
	<script src="https://kit.fontawesome.com/c2dbfd9242.js" crossorigin="anonymous"></script>
	<title>Questionnaire</title>

<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">test</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Link</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Dropdown
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Another action</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Something else here</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link disabled" href="#">Disabled</a>
      </li>
    </ul>
    <form class="form-inline my-2 my-lg-0">
      	<input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
      	<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
  </div>
</nav>
    
 	<form class="w-25 m-auto" method="post" action="#">
  		<div id="carouselExampleIndicators" class="carousel slide" data-interval="false" data-ride="carousel">
		  	<ol class="carousel-indicators bg-dark">
		  		<?php 
		  		$row = -1;
		  		$quest = null;
		  		$lines = [];
		  		if (($handle = fopen("quest.csv", "r")) !== FALSE) {
				    while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) 
				    { 
				    	$data = array_map("utf8_encode", $data) ;
                            $lines[] = $data ;
				    	
				    	if ($row == -1) {$row++;}
				    	else{	
				    		if( $data[2] != null){
				    			if ($row == 0) {
					    			 echo "<li data-target='#carouselExampleIndicators' data-slide-to='$row' class='active'></li>";
					    			 $row++;
					    		}
				    			else{
				    				echo "<li data-target='#carouselExampleIndicators' data-slide-to='$row'></li>";
				    				$row++; 	
				    			}
				    		}
				    	}
				    }
				    echo "<li data-target='#carouselExampleIndicators' data-slide-to='$row'></li>";
				}
				fclose($handle);
		  		?>
		  	</ol>
		  	<div class="carousel-inner">
		  		<?php 
		  		$quest = null;
		  		$data;
				    for ($i=1; $i < count($lines); $i++) { 
				        	$data = $lines[$i];	

				        		$quest = $data[2];?>
				        	<div class="carousel-item <?php if($i == 1){ echo "active";} ?> p-5">
						    	<div class="card m-auto" style="width: 18rem;">
									<div class="card-header"><?php echo $data[0]. "<i class='".$data[1]."'></i>"; ?>
									</div>
									<div class="card-body">
										<h5 class="card-title"><?php echo $data[2]; ?></h5>
									    <div class="form-group">
										    <label for="Input<?php echo $i; ?>"><?php echo $data[4]; ?></label>
										    <input type="<?php echo $data[3]; ?>" class="form-control" id="Input<?php echo $i; ?> " <?php if ($data[3] == "radio") {
										    	$name = "name_$i";
										    	echo "name='$name'";
										    }
										    else {
										    	echo "name='name_$i'";
										    }?>value="<?php echo $data[5]; ?>">

									  	</div>
										<?php 
										$i++;
										$data = $lines[$i];	
										while ( $data[2] == null && $i < count($lines)) { ?>
											<div class="form-group">
												<label for="Input<?php echo $i; ?>"><?php echo $data[4]; ?></label>
											    <input type="<?php echo $data[3]; ?>" class="form-control" id="Input<?php echo $i; ?>"  value="<?php echo $data[5]; ?>" 
										<?php if ($data[3] == "radio") {
										    	echo "name='$name'";
										    }
										    else {
										    	echo "name='name_$i'";
										    }?>>
											</div>
										<?php
										$i++;
										if ($i < count($lines)) {
														$data = $lines[$i];
														}			    	
									    } 
									    $i--;
									    ?>
									</div>
								</div>
							</div>

				        	<?php
				    }
		  		?>
		  		<div class="carousel-item p-5">
						    	<div class="card m-auto" style="width: 18rem;">
									<div class="card-header">Fin
									</div>
									<div class="card-body">
										<h5 class="card-title">Voir le résultat</h5>
									    <div class="form-group">
										    <button type="submit" class="btn btn-primary">Voir</button>
									  	</div>						
									</div>
								</div>
							</div>
			    </div>
			    <a class="btn btn-primary" href="#carouselExampleIndicators" role="button" data-slide="next" style="float: right;margin: -50%;">
			    <span class="">Suivant <span class="carousel-control-next-icon" aria-hidden="true"></span></span>
			</a>
			</div>
			
	</form>

<?php
if (isset($total)) {
	?>
<div class="d-flex w-100">
	<h1 class="display-3 m-auto">Vous avez un score de <?php  echo $total; ?> !</h1>
</div>
	<?php
}

?>

	<script src="js/jquery.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="js/bootstrap.min.js"></script>

</body>
</html>
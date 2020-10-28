<!--Boton HOME-->
<nav class="navbar navbar-expand-lg p-0" style="background-image: url(https://us.123rf.com/450wm/kebox/kebox1705/kebox170500033/77319728-fondo-degradado-rayas-colores-rojo-y-negro.jpg?ver=6); 
		background-repeat: no-repeat;     
		background-size: cover;
        -moz-background-size: cover;
        -webkit-background-size: cover;
        -o-background-size: cover;">
	<ul class="navbar-nav mr-auto  mt-1 mt-lg-0" >
		<li class="nav-item active" >
			<strong><a class="nav-link text-white"  href="/TP-MoviePass/index.php">Home</a></strong>  
		</li>
	</ul>

<!--Dropdown buscar por género-->
	<ul class="navbar-nav mr-auto " style="margin-left:65%; " >
		
		<li class="nav-item" >
			<div class="dropdown">
				<form class="form-inline my-2  my-lg-2 " action="<?php echo FRONT_ROOT?>Movie/listByGenre" method=POST>
					<button class="btn btn-secondary btn-dark dropdown-toggle" style="margin-right:10px; "  type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					Genre
					</button>
					<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
		
						<!-- 
						ESTO FUE CORREGIDO: No se debe instanciar una controladora desde una vista.
						Necesitamos utilizar AJAX o JQuery para llamar al controlador MovieController
						y colocar todos los diferentes generos en el dropdown (atributo onchange="")
						Por falta de tiempo no se implemento. 
						-->

						<?php							
								foreach ($genresList as $genre){
								?>
								<button type ="submit" class="dropdown-item" name="genreId" value="<?php echo $genre->getId(); ?>"><?php echo $genre->getName();?></button>
							<?php } ?>

					</div>
				</form>
			</div>
		</li>

		<!--Dropdown calendario, buscar por fecha-->
		<li>
			<div class="dropdown">
				<form class="form-inline my-2  my-lg-2 " action="<?php echo FRONT_ROOT?>Movie/getMoviesByDate" method=POST?>
					<button class="btn btn-secondary btn-dark dropdown-toggle" style="margin-right:10px;" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Years
					</button>
					
					<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
						<?php if(!empty($moviesYearList)){ 
							foreach($moviesYearList as $year){ ?>
							<button type ="submit" class="dropdown-item" name="year" value="<?php echo $year;?>"><?php echo $year;?></button>
						<?php }
					} ?>
					</div>
				</form>
			</div>
		</li>

<!--SESSION USER DROPDOWN-->
		<li>
			<div class="dropdown">
				<form class="form-inline my-2  my-lg-2 ">

			<?php if(!isset($_SESSION['loggedUser'])){ ?> <!--  USER NOT LOGGED -->

					<button class="btn btn-secondary btn-dark dropdown-toggle" style="margin-right:10px;" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Hello Guest!
					</button>
					
					<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
							<button type ="button" class="dropdown-item" value="Sing In" onclick="window.location.href='<?php echo FRONT_ROOT?>User/showLoginForm'">Sing In</button>
							<button type ="button" class="dropdown-item" value="Register" onclick="window.location.href='<?php echo FRONT_ROOT?>User/register'">Register</button>
					</div>
				
			<?php } else { ?> <!--IS LOGGED -->
				
					<button class="btn btn-secondary btn-dark dropdown-toggle" style="margin-right:10px;" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Hello <?=$_SESSION['loggedUser']?>!
					</button>
					
					<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
							<button type ="button" disabled class="dropdown-item" value="MyAccount" onclick="URL">My Account</button>				

					<?php if($_SESSION['role'] == 'admin') { ?> <!-- IS ADMIN -->
							
							<button type ="button" class="dropdown-item" value="AdminTools" onclick="window.location.href='<?php echo FRONT_ROOT?>User/adminView'">Admin Tools</button>

					<?php } else if($_SESSION['role'] == 'owner'){?>

							<button type ="button" disabled class="dropdown-item" value="OwnerTools" onclick="window.location.href='<?php echo FRONT_ROOT?>User/ownerView'">Owner Tools</button>
							
						<?php } ?>
						 
					<button type ="button" class="dropdown-item" value="Logout" onclick="window.location.href='<?php echo FRONT_ROOT?>User/logout'">Logout</button>
				
					</div>

					<?php }?>

				</form>
			</div>
		</li>
	</ul>      

</nav>

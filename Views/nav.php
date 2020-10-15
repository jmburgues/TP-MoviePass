<?php
use Controllers\GenreController as GenreController;
use Controllers\MovieController as MovieController;
?>

<!--Barra de navegación que estará presente en todo el programa-->
<!--Prensenta un boton de vuelta al inicio, 2 buscadores de películas, login, signin y exit en caso de estar logueado-->

<!--Boton HOME-->
<nav class="navbar navbar-expand-lg p-2" style="background-image: url(https://us.123rf.com/450wm/kebox/kebox1705/kebox170500033/77319728-fondo-degradado-rayas-colores-rojo-y-negro.jpg?ver=6); 
		background-repeat: no-repeat;     
		background-size: cover;
        -moz-background-size: cover;
        -webkit-background-size: cover;
        -o-background-size: cover;"   >
	<ul class="navbar-nav mr-auto  mt-2 mt-lg-0" >
    <li class="nav-item active" >
		<strong><a class="nav-link text-white"  href="/TP-MoviePass/index.php">Home</a></strong>  
    </li>
	</ul>

<!--Dropdown buscar por género-->
	<ul class="navbar-nav mr-auto mt-2 mt-lg-0">
	

		<li class="nav-item">

		<div class="dropdown">
	<form class="form-inline my-2  my-lg-2 " action="<?php echo FRONT_ROOT?>Movie/listByGenre" method=POST?>
		<button class="btn btn-secondary btn-light dropdown-toggle" style="margin-right:10px; "  type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			Buscar por genero
		</button>
		<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
		
		<!-- PREGUNTAR !!! -->
		<!-- LA VISTA DEBERIA LLAMAR AL CONTROLADOR DE GENEROS ?? -->
		
			<?php 
			$genreController = new GenreController();
			$genres = $genreController->getGenresList();
			foreach ($genres as $genre){?>
				<button type ="submit" class="dropdown-item" name="genreId" value="<?php echo $genre->getId(); ?>"><?php echo $genre->getName();?></button>
			<?php } ?>

		</div>
			</form>
		</div>
		</li>
<li>
<!--Dropdown calendario, buscar por fecha-->
	<div class="dropdown">
		<form class="form-inline my-2  my-lg-2 " action="<?php echo FRONT_ROOT?>Movie/getMoviesByDate" method=POST?>
			<button class="btn btn-secondary btn-light dropdown-toggle" style="margin-right:10px;" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				Años
			</button>
			<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
				<?php
					$movieController = new MovieController();
					$years = $movieController->getArrayOfYears();
					//var_dump($years);
					foreach($years as $year){
				?>
					<button type ="submit" class="dropdown-item" name="year" value="<?php echo $year;?>"><?php echo $year;?></button>
					
				<?php	}
				?>
			</div>
		</form>
	</div>
</li>

<!--Botones Nav-->
		<li>
			<strong><a class="nav-link  text-white" href="<?php echo FRONT_ROOT?>User/showLoginForm">SignIn</a></strong>
		</li>
		<li>
			<strong><a class="nav-link  text-white" href="<?php echo FRONT_ROOT?>User/register">SignUp</a></strong>
		</li>
		<li>
			<strong><a class="nav-link  text-white" href="/TP-MoviePass/index.php">Exit</a></strong>
		</li>
    </ul>      
    </form>

  </div>
</nav>

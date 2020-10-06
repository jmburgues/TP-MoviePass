<!--Barra de navegación que estará presente en todo el programa-->
<!--Prensenta un boton de vuelta al inicio, 2 buscadores de películas, login, signin y exit en caso de estar logueado-->

<!--ESTO DEBERÍA ESTAR EN UN .CSS-->
<!--Boton HOME-->
<nav class="navbar navbar-expand-lg p-2" style="background-image: url(https://us.123rf.com/450wm/kebox/kebox1705/kebox170500033/77319728-fondo-degradado-rayas-colores-rojo-y-negro.jpg?ver=6); 
		background-repeat: no-repeat;     
		background-size: cover;
        -moz-background-size: cover;
        -webkit-background-size: cover;
        -o-background-size: cover;"   >
	<ul class="navbar-nav mr-auto  mt-2 mt-lg-0" >
    <li class="nav-item active" >
		<strong><a class="nav-link text-white" href="home">Home<span class="sr-only">(current)</span></a></strong>  
    </li>
	</ul>

<!--Dropdown buscar por género-->
	<form class="form-inline my-2 my-lg-0 ">
	<ul class="navbar-nav mr-auto mt-2 mt-lg-0">
		
	<li class="nav-item">

	<div class="dropdown">
  <button class="btn btn-secondary btn-light dropdown-toggle" style="margin-right:10px; "  type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Buscar por genero
  </button>
  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
    <a class="dropdown-item" href="#">Accion</a>
    <a class="dropdown-item" href="#">Drama</a>
    <a class="dropdown-item" href="#">Comedia</a>
  </div>
</div>
</li>
<li class="nav-item">

<!--Dropdown calendario, buscar por fecha-->
<div class="dropdown">
<button class="btn btn-secondary btn-light dropdown-toggle" style="margin-right:10px;" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
Soy un calendario
</button>
<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
<a class="dropdown-item" href="#">14/14</a>
<a class="dropdown-item" href="#">15/15</a>
<a class="dropdown-item" href="#">16/16</a>
</div>
</div>
</li>

<!--Boton SignIn-->
		<li>
			<strong><a class="nav-link  text-white" href="#">SignIn</a></strong>  
		</li>
<!--Boton SignUp-->
		<li class="nav-item">
			<strong><a class="nav-link  text-white" href="#">SignUp</a></strong>  
		</li>
<!--Boton Exit-->
		<li class="nav-item">
			<strong><a class="nav-link  text-white" href="#">Exit</a></strong>  
		</li>
    </ul>      
    </form>

  </div>
</nav>
